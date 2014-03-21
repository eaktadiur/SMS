<?php

/**
 * Single tone pattern
 */
class DB {

    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_result,
            $_count = 0;

    private function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . '; dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query($sql, $params = array()) {

        $this->_error = false;
        //echo $sql;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $key => $value) {
                    $this->_query->bindValue($x, $value);
                    $x++;
                }
            }


            if ($this->_query->execute()) {
                $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }

        return $this;
    }

    public function action($action, $table, $where = array()) {
        if (count($where === 3)) {
            $operators = array('=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
    }

    public function get($table, $where) {
        return $this->action("SELECT * ", $table, $where);
    }

    public function delete($table, $where) {
        return $this->action("DELETE", $table, $where);
    }

    public function error() {
        return $this->_error;
    }

    public function count() {
        return $this->_count;
    }

    public function results() {
        return $this->_result;
    }

    public function insert($table, $fields = array()) {
        if (count($fields)) {
            $key = array_keys($fields);
            $values = NULL;
            $x = 1;
            foreach ($fields AS $field) {
                $values.="?";
                if ($x < count($fields)) {
                    $values.=', ';
                }
                $x++;
            }

            $sql = "INSERT INTO $table (`" . implode('`,`', $key) . "`) VALUES({$values})";
            if (!$this->query($sql, $fields)->error()) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function update($table, $id, $fields = array()) {
        $set = '';
        $x = 1;
        foreach ($fields as $name => $value) {
            $set.="`{$name}`= ?";
            if ($x < count($fields)) {
                $set.=', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE UserTableId='{$id}'";

        if (!$this->query($sql, $fields)->error()) {
            return TRUE;
        }
        return FALSE;
    }

    public function first() {
        //return first value
        return $this->results()[0];
    }

}

?>