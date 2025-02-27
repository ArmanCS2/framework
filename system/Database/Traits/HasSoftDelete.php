<?php


namespace System\Database\Traits;

trait HasSoftDelete{

    protected function getMethod($array=[]){
        if($this->getSql()==''){
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
        $this->setWhere($this->getAttributeName($this->deletedAt) . " IS NULL",'AND');
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
        if ($object) {
            $object->setSql("UPDATE " . $object->getTableName() . " SET " . $object->getAttributeName($object->deletedAt) . "=NOW()");
            $object->setWhere($object->getAttributeName($object->primary_key) . "= ?", 'AND');
            $object->addValue($object->primary_key, $object->{$object->primary_key});
            return $object->executeQuery();
        }

    }

    protected function paginateMethod($perPage){
        $this->setWhere($this->getAttributeName($this->deletedAt) . " IS NULL",'AND');
        $totalRows=$this->getCount();
        $currentPage= isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $totalPages=ceil($totalRows/$perPage);
        $currentPage=min($currentPage,$totalPages);
        $currentPage=max($currentPage,1);
        $currentRow=($currentPage-1) * $perPage;

        $this->setLimit($currentRow,$perPage);

        if($this->getSql()==''){
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
    protected function findMethod($id)
    {
        $this->resetQuery();
        $this->setSql("SELECT " . $this->getTableName() . ".* FROM " . $this->getTableName());
        $this->setWhere($this->getAttributeName($this->primary_key) . "=?");
        $this->addValue($this->primary_key, $id);
        $this->setWhere($this->getAttributeName($this->deletedAt) . " IS NULL",'AND');
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
        $this->setWhere($this->getAttributeName($this->deletedAt) . " IS NULL ",'AND');
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();
        if ($data) {
            $this->arrayToObjects($data);
            return $this->collection;
        }
        return [];
    }
}