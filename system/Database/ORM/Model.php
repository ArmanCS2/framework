<?php


namespace System\Database\ORM;

use System\Database\Traits\HasAttributes;
use System\Database\Traits\HasCRUD;
use System\Database\Traits\HasMethodCaller;
use System\Database\Traits\HasQueryBuilder;
use System\Database\Traits\HasRelation;

class Model{
    use HasQueryBuilder,HasAttributes,HasCRUD,HasMethodCaller,HasRelation;
    protected $table;
    protected $fillable=[];
    protected $hidden=[];
    protected $casts=[];
    protected $primary_key='id';
    protected $createdAt='created_at';
    protected $updatedAt='updated_at';
    protected $deletedAt='deleted_at';
    protected $collection=[];
    public $properties=[];
    public function __set($name, $value)
    {
        $this->properties[$name]=$value;
    }
    public function __get($name)
    {
        return $this->properties[$name];
    }
}