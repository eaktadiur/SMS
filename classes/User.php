<?php

class User {

    private $_db, $_data, $_sessionName, $_cookieName, $_isLoggedIn;

    public function __construct($user = null) {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if (!$user) {

            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);
                if ($this->find($user)) {
                    $this->_isLoggedIn = TRUE;
                } else {
//Log out    
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function update($fields = array(), $userId = null) {
        if (!$userId && $this->isLoggedIn()) {
            $userId = $this->data()->UserId;
        }

        if (!$this->_db->update('user_table', $userId, $fields)) {
            throw new Exception('There was a problem updating');
        }
    }

    public  function hasPermission($key) {
        $group = $this->_db->get('groups', array('GroupId', '=', $this->data()->Group));

        if ($group->count()) {
            $permissions = json_decode($group->first()->Permissions, TRUE);

            if ($permissions[$key] == TRUE) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function create($fields = array()) {

        if (!$this->_db->insert('user_table', $fields)) {
            throw new Exception('There was a problem creating an account');
        }
    }

    public function find($user = null) {
        if ($user) {
            $fied = (is_numeric($user)) ? 'UserId' : 'UserName';
            $data = $this->_db->get('user_table', array($fied, '=', $user));
            if ($data->count()) {
                $this->_data = $data->first();
                return TRUE;
            }
        }
        return FALSE;
    }

    public function login($username = null, $password = null, $remember = false) {



        if (!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->UserId);
        } else {
            $user = $this->find($username);
            if ($user) {
                if ($this->data()->Password === Hash::make($password, $this->data()->Salt)) {
                    Session::put($this->_sessionName, $this->data()->UserName);

                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('user_session', array('UserId', '=', $this->data()->UserId));

                        if (!$hashCheck->count()) {
                            $this->_db->insert('user_session', array(
                                'UserId' => $this->data()->UserId,
                                'Hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->Hash;
                        }


                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }

                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    public function exists() {
        return (!empty($this->_data) ? TRUE : FALSE);
    }

    public function logout() {

        $this->_db->delete('user_session', array('UserId', '=', $this->data()->UserId));
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function data() {
        return $this->_data;
    }

    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }

}
