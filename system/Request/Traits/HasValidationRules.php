<?php


namespace System\Request\Traits;

use System\Database\DBConnection\DBConnection;
use System\Session\Session;

trait HasValidationRules
{
    public function normalValidation($attribute, $rules)
    {
        foreach ($rules as $rule) {
            if ($rule == 'required') {
                $this->required($attribute);
            } elseif (strpos($rule, 'max:') === 0) {
                $rule = str_replace('max:', '', $rule);
                $this->maxStr($attribute, $rule);
            } elseif (strpos($rule, 'min:') === 0) {
                $rule = str_replace('min:', '', $rule);
                $this->minStr($attribute, $rule);
            } elseif (strpos($rule, 'exists:') === 0) {
                $rule = str_replace('exists:', '', $rule);
                $rule = explode(',', $rule);
                $key = isset($rule[1]) ? $rule[1] : null;
                $this->existsIn($attribute, $rule[0], $key);
            }elseif (strpos($rule, 'unique:') === 0) {
                $rule = str_replace('unique:', '', $rule);
                $rule = explode(',', $rule);
                $key = isset($rule[1]) ? $rule[1] : null;
                $this->unique($attribute, $rule[0], $key);
            }elseif ($rule == 'confirmed') {
                $this->confirm($attribute);
            } elseif ($rule == 'email') {
                $this->email($attribute);
            } elseif ($rule == 'date') {
                $this->date($attribute);
            }elseif($rule == 'validToken'){
                $this->checkToken($attribute);
            }
        }
    }

    public function numberValidation($attribute, $rules)
    {
        foreach ($rules as $rule) {
            if ($rule == 'required') {
                $this->required($attribute);
            } elseif (strpos($rule, 'max:') === 0) {
                $rule = str_replace('max:', '', $rule);
                $this->maxNumber($attribute, $rule);
            } elseif (strpos($rule, 'min:') === 0) {
                $rule = str_replace('min:', '', $rule);
                $this->minNumber($attribute, $rule);
            } elseif (strpos($rule, 'exists:') === 0) {
                $rule = str_replace('exists:', '', $rule);
                $rule = explode(',', $rule);
                $key = isset($rule[1]) ? $rule[1] : null;
                $this->existsIn($attribute, $rule[0], $key);
            }elseif (strpos($rule, 'unique:') === 0) {
                $rule = str_replace('unique:', '', $rule);
                $rule = explode(',', $rule);
                $key = isset($rule[1]) ? $rule[1] : null;
                $this->unique($attribute, $rule[0], $key);
            }elseif ($rule == 'confirmed') {
                $this->confirm($attribute);
            } elseif ($rule == 'number') {
                $this->number($attribute);
            }
        }
    }

    protected function required($attribute)
    {
        if ((!isset($this->request[$attribute]) || $this->request[$attribute]=='')  && $this->checkFirstError($attribute)) {
            $this->setError($attribute, "$attribute is required");
        }
    }

    protected function maxStr($attribute, $count)
    {
        if ($this->checkFieldExists($attribute)) {
            if (strlen($this->request[$attribute]) > $count && $this->checkFirstError($attribute)) {
                $this->setError($attribute, "$attribute max length is $count");
            }
        }
    }

    protected function minStr($attribute, $count)
    {
        if ($this->checkFieldExists($attribute)) {
            if (strlen($this->request[$attribute]) < $count && $this->checkFirstError($attribute)) {
                $this->setError($attribute, "$attribute min length is $count");
            }
        }
    }

    protected function maxNumber($attribute, $count)
    {
        if ($this->checkFieldExists($attribute)) {
            if ($this->request[$attribute] > $count && $this->checkFirstError($attribute)) {
                $this->setError($attribute, "$attribute max length is $count");
            }
        }
    }

    protected function minNumber($attribute, $count)
    {
        if ($this->checkFieldExists($attribute)) {
            if ($this->request[$attribute] < $count && $this->checkFirstError($attribute)) {
                $this->setError($attribute, "$attribute min length is $count");
            }
        }
    }


    protected function number($attribute)
    {
        if ($this->checkFieldExists($attribute)) {
            if (!is_numeric($this->request[$attribute]) && $this->checkFirstError($attribute)) {
                $this->setError($attribute, "$attribute should be number");
            }
        }
    }

    protected function email($attribute)
    {
        if ($this->checkFieldExists($attribute)) {
            if (!filter_var($this->request[$attribute], FILTER_VALIDATE_EMAIL) && $this->checkFirstError($attribute)) {
                $this->setError($attribute, "$attribute should be email format");
            }
        }
    }
    public function checkToken($attribute){
        if ($this->checkFieldExists($attribute)) {
            if (!hash_equals($this->request[$attribute],Session::get('CSRF'))){
                $this->setError($attribute, "$attribute not valid");
            }
        }
    }

    protected function date($attribute)
    {
        if ($this->checkFieldExists($attribute)) {
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->request[$attribute]) && $this->checkFirstError($attribute)) {
                $this->setError($attribute, "$attribute should be date format");
            }
        }
    }

    public function existsIn($attribute, $table, $field = 'id')
    {
        if ($this->checkFieldExists($attribute)) {
            if ($this->checkFirstError($attribute) && $this->request[$attribute]!='') {
                $value = $this->$attribute;
                $sql = "SELECT COUNT(*) FROM $table WHERE $field=?";
                $statement = DBConnection::getDBConnectionInstance()->prepare($sql);
                $statement->execute([$value]);
                $result = $statement->fetchColumn();
                if (!$result) {
                    $this->setError($attribute, "$attribute not exists in $table with $field");
                }

            }
        }
    }


    public function unique($attribute, $table, $field = 'id')
    {
        if ($this->checkFieldExists($attribute)) {
            if ($this->checkFirstError($attribute) && $this->request[$attribute]!='') {
                $value = $this->$attribute;
                $sql = "SELECT COUNT(*) FROM $table WHERE $field=?";
                $statement = DBConnection::getDBConnectionInstance()->prepare($sql);
                $statement->execute([$value]);
                $result = $statement->fetchColumn();
                if ($result) {
                    $this->setError($attribute, "$attribute already exists");
                }

            }
        }
    }

    protected function confirm($attribute)
    {
        if ($this->checkFieldExists($attribute)) {
            $fieldName="confirm_".$attribute;
            if (!isset($this->$attribute)){
                $this->setError($attribute, "$attribute confirmation not exists");
            }elseif ($this->$fieldName!=$this->$attribute){
                $this->setError($fieldName, "$fieldName doesn't match");
            }
        }
    }
}