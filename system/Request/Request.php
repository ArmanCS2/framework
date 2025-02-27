<?php

namespace System\Request;

use System\Request\Traits\HasFileValidationRules;
use System\Request\Traits\HasRunValidation;
use System\Request\Traits\HasValidationRules;

class Request{
    use HasFileValidationRules,HasValidationRules,HasRunValidation;
    protected bool $errorExists=false;
    protected $request;
    protected $files=null;
    protected $errorVariableNames=[];

    public function __construct()
    {
        if(isset($_POST)){
            $this->postAttributes();
        }

        if(isset($_GET)){
            $this->getAttributes();
        }

        if (isset($_FILES)){
            $this->files=$_FILES;
        }
        $rules=$this->rules();
        empty($rules) ? : $this->run($rules);
        $this->errorRedirect();
    }

    public function rules(){
        return [];
    }

    protected function run($rules){
        foreach ($rules as $attribute => $values){
            $rulesArray=explode('|',$values);
            if(in_array('file',$rulesArray)){
                unset($rulesArray[array_search('file',$rulesArray)]);
                $this->fileValidation($attribute,$rulesArray);
            }elseif (in_array('number',$rulesArray)){
                $this->numberValidation($attribute,$rulesArray);
            }else{
                $this->normalValidation($attribute,$rulesArray);
            }
        }
    }

    public function file($name){
        return isset($_FILES[$name]) ? $_FILES[$name] : false ;
    }
    public function all(){
        return $this->request;
    }

    public function files(){
        return $this->files;
    }
    public function valid($value){
        $data=trim($value," ");
        $data=stripslashes($data);
        $data=htmlentities($data);
        return $data;
    }

    protected function postAttributes(){
        foreach ($_POST as $key => $value){
            $this->$key=$this->valid($value);
            $this->request[$key]=$this->valid($value);
        }

    }

    protected function getAttributes(){
        foreach ($_GET as $key => $value){
            $this->$key=$this->valid($value);
            $this->request[$key]=$this->valid($value);
        }

    }
}
