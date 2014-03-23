<?php

class Validate {

    private $_passed = false,
            $_error = array(),
            $_db = null;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array()) {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                //echo "{$item} {$rule} must be {$rule_value} <br>";
                $value = trim($source[$item]);
                //echo $value . '<br>';
                $item = escape($item);

                if ($rule === 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } elseif (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < ($rule_value)) {
                                $this->addError("{$item} must be a minimum {$rule_value} character.");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > ($rule_value)) {
                                $this->addError("{$item} must be a maximum {$rule_value} character.");
                            }
                            break;
                        case 'match':
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} not match {$item}.");
                            }

                            break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if ($check->count()) {
                                $this->addError("{$item} already exists");
                            }
                            break;

                    }
                }
            }
        }

        if (empty($this->_error)) {
            $this->_passed = TRUE;
        }

        return $this;
    }

    private function addError($error) {
        $this->_error[] = $error;
    }

    public function errors() {
        return $this->_error;
    }

    public function passed() {
        return $this->_passed;
    }

}

?>