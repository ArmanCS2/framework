<?php

namespace System\Database\Traits;

use System\Database\DBConnection\DBConnection;

trait HasCRUD
{
    protected function createMethod($values){
        $values=$this->arrayToCastEncodeValue($values);
        $this->arrayToAttributes($values,$this);
        $this->saveMethod();

    }
    protected function updateMethod($values){
        $values=$this->arrayToCastEncodeValue($values);
        $this->arrayToAttributes($values,$this);
        $this->saveMethod();

    }
    protected function paginateMethod($perPage){
        $totalRows=$this->getCount();
        $currentPage= isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $totalPages=ceil($totalRows/$perPage);
        $currentPage=min($currentPage,$totalPages);
        $currentPage=max($currentPage,1);
        $currentRow=($currentPage-1) * $perPage;

        $this->setLimit($currentRow,$perPage);

        if($this->sql==''){
            $this->setSql("SELECT " . $this->getTableName() . ".* FROM " . $this->getTableName());
        }
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();
        if ($data) {
            $this->arrayToObjects($data);
            return $this->collection;
        }
        return [];
    }
    protected function getMethod($array=[]){
        if($this->sql==''){
            if(empty($array)){
                $fields = $this->getTableName().".*";
            }else{
                foreach ($array as $key =>$field){
                    $array[$key]=$field;
                }
                $fields=implode(',',$array);
            }
            $this->setSql("SELECT " . $fields . " FROM " . $this->getTableName());
        }
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();

        if ($data) {
            $this->arrayToObjects($data);
            return $this->collection;
        }
        return [];
    }
    protected function orderByMethod($attribute,$expression='ASC'){
        $this->setOrderBy($attribute,$expression);
        $this->setAllowedMethods(['limit', 'orderBy', 'get', 'paginate']);
        return $this;
    }
    protected function limitMethod($from,$count){
        $this->setLimit($from,$count);
        $this->setAllowedMethods(['limit','get', 'paginate']);
        return $this;
    }
    protected function whereMethod($attribute, $firstValue, $secondValue = null)
    {

        if ($secondValue == null) {
            $condition = $this->getAttributeName($attribute) . "= ?";
            $this->addValue($attribute, $firstValue);
        } else {
            $condition = $this->getAttributeName($attribute) . $firstValue . "?";
            $this->addValue($attribute, $secondValue);
        }
        $this->setWhere($condition, 'AND');
        $this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'limit', 'orderBy', 'get', 'paginate']);
        return $this;
    }

    protected function whereOrMethod($attribute, $firstValue, $secondValue = null)
    {
        if ($secondValue == null) {
            $condition = $this->getAttributeName($attribute) . "= ?";
            $this->addValue($attribute, $firstValue);
        } else {
            $condition = $this->getAttributeName($attribute) . $firstValue . "?";
            $this->addValue($attribute, $secondValue);

        }
        $this->setWhere($condition, 'OR');
        $this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'limit', 'orderBy', 'get', 'paginate']);
        return $this;
    }

    protected function whereNullMethod($attribute)
    {
        $condition = $this->getAttributeName($attribute) . " IS NULL ";
        $this->setWhere($condition , 'AND');
        $this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'limit', 'orderBy', 'get', 'paginate']);
        return $this;
    }

    protected function whereNotNullMethod($attribute)
    {
        $condition = $this->getAttributeName($attribute) . " IS NOT NULL ";
        $this->setWhere($condition,'AND');
        $this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'limit', 'orderBy', 'get', 'paginate']);
        return $this;
    }

    protected function whereInMethod($attribute,$values)
    {

        if(is_array($values)){
            $newValues=[];
            foreach ($values as $value) {
                $this->addValue($attribute,$value);
                array_push($newValues,"?");
            }
            $condition=$this->getAttrinbuteName($attribute) . " IN (" . implode(', ',$newValues) . ')';
            $this->setWhere($condition,'AND');
            $this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'limit', 'orderBy', 'get', 'paginate']);
            return $this;
            return $this;
        }
    }

    protected function findMethod($id)
    {
        $this->resetQuery();
        $this->setSql("SELECT " . $this->getTableName() . ".* FROM " . $this->getTableName());
        $this->setWhere($this->getAttributeName($this->primary_key) . "=?",'AND');
        $this->addValue($this->primary_key, $id);
        $statement = $this->executeQuery();
        $data = $statement->fetch();
        $this->setAllowedMethods(['update', 'delete', 'save']);
        if ($data) {
            return $this->arrayToAttributes($data);
        }
        return null;
    }

    protected function allMethod()
    {
        $this->resetQuery();
        $this->setSql("SELECT " . $this->getTableName() . ".* FROM " . $this->getTableName());
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();
        if ($data) {
            $this->arrayToObjects($data);
            return $this->collection;
        }
        return [];
    }

    protected function deleteMethod($id = null)
    {
        $object = $this;
        $this->resetQuery();
        if ($id) {
            $object = $this->findMethod($id);
        }

        $object->setSql("DELETE FROM " . $object->getTableName());
        $object->setWhere($object->getAttributeName($object->primary_key) . "= ?");
        $object->addValue($object->primary_key, $object->{$object->primary_key});
        return $object->executeQuery();
    }

    protected function saveMethod()
    {
        $fillString = $this->fill();
        $primary_key=$this->properties[$this->primary_key];
        if (!isset($primary_key)) {
            $this->setSql("INSERT INTO " . $this->getTableName() . " SET " . $fillString . ", " . $this->getAttributeName($this->createdAt) . "=NOW()");

        } else {
            $this->setSql("UPDATE " . $this->getTableName() . " SET " . $fillString . ", " . $this->getAttributeName($this->updatedAt) . "=NOW()");
            $this->setWhere($this->primary_key . "= ?");
            $this->addValue($this->primary_key, $this->{$this->primary_key});
        }
        $this->executeQuery();
        $this->resetQuery();
        if (!isset($primary_key)) {
            $object = $this->findMethod(DBConnection::newInsertId());
            $defaultVars = get_class_vars(get_called_class());
            $allVars = get_object_vars($object);
            $differentVars = array_diff(array_keys($allVars), array_keys($defaultVars));
            foreach ($differentVars as $attribute) {
                $this->inCastAttributes($attribute) == true ?
                    $this->registerAttribute($this, $attribute, $this->castEncodeValue($attribute, $object->properties[$attribute]))
                    :
                    $this->registerAttribute($this, $attribute, $object->properties[$attribute]);
            }

        }
        $this->resetQuery();
        $this->setAllowedMethods(['update', 'delete', 'find']);
        return $this;

    }

    protected function fill()
    {
        $fillArray = [];

        foreach ($this->fillable as $attribute) {
            if (isset($this->properties[$attribute])) {
                if($this->properties[$attribute]==''){
                    $this->properties[$attribute]=null;
                }
                array_push($fillArray, $this->getAttributeName($attribute) . " = ?");
                if ($this->inCastAttributes($attribute)) {
                    $this->addValue($attribute, $this->castEncodeValue($attribute, $this->properties[$attribute]));
                } else {
                    $this->addValue($attribute, $this->properties[$attribute]);
                }
            }
        }
        $fillString = implode(', ', $fillArray);
        return $fillString;
    }
}
