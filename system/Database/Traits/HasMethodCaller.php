<?php

 namespace System\Database\Traits;

 trait HasMethodCaller{
     private $allMethods=['create','update','delete','all','save','get','find','where','whereOr','whereNull',
         'whereNotNull','whereIn','limit','orderBy','paginate'];
     private $allowedMethods=['create','update','delete','all','save','get','find','where','whereOr','whereNull',
         'whereNotNull','whereIn','limit','orderBy','paginate'];

     public function __call($method,$args){
         return $this->methodCaller($this,$method,$args);
     }
     public static function __callStatic($method,$args){
         $className=get_called_class();
         $instance=new $className();
         return $instance->methodCaller($instance,$method,$args);
     }

     protected function setAllowedMethods($allowedMethods){
         $this->allowedMethods=$allowedMethods;
     }

     private function methodCaller($object,$method,$args){
         $suffix='Method';
         $methodName=$method . $suffix;
         if(in_array($method,$this->allowedMethods)){
         return call_user_func_array(array($object,$methodName),$args);

         }
     }

 }