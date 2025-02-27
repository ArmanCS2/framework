<?php

namespace System\Request\Traits;

trait HasRunValidation{

    protected function errorRedirect(){
        if($this->errorExists==false){
            return $this->request;
        }
        return back();
    }

    protected function checkFirstError($attribute){
        if(!errorExists($attribute) && !in_array($attribute,$this->errorVariableNames)){
            return true;
        }
        return false;
    }

    protected function checkFieldExists($attribute){
        return isset($this->request[$attribute]) ? true : false;
    }

    protected function checkFileExists($attribute){
        return !empty($this->files[$attribute]['name']) ? true : false;
    }

    protected function setError($attribute,$message){
        array_push($this->errorVariableNames,$attribute);
        error($attribute,$message);
        $this->errorExists=true;
    }
}
