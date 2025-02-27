<?php

namespace System\Database\Traits;

use System\Database\DBConnection\DBConnection;

trait HasQueryBuilder
{
    private $sql = '';
    protected $where = [];
    private $orderBy = [];
    private $limit = [];
    private $values = [];
    private $bindValues = [];

    protected function setSql($query)
    {
        $this->sql = $query;
    }

    protected function getSql()
    {
        return $this->sql;
    }

    protected function resetSql()
    {
        $this->sql = "";
    }

    protected function setWhere($condition, $operator="AND")
    {
        array_push($this->where, ['condition' => $condition, 'operator' => $operator]);

    }

    protected function resetWhere()
    {
        $this->where = [];
    }

    protected function setOrderBy($attribute, $expression="ASC")
    {
        array_push($this->orderBy,  $this->getAttributeName($attribute) . " " . $expression);

    }

    protected function resetOrderBy()
    {
        $this->orderBy = [];
    }

    protected function setLimit($from,$count){
        $this->limit=['from'=>$from,'count'=>$count];
    }

    protected function resetLimit(){
        $this->limit=[];
    }

    protected function addValue($attribute,$value){
        $this->values[$this->getAttributeName($attribute)]=$value;
        array_push($this->bindValues,$value);
    }

    protected function resetValues(){
        $this->values=[];
        $this->bindValues=[];
    }

    protected function resetQuery(){
        $this->resetSql();
        $this->resetWhere();
        $this->resetOrderBy();
        $this->resetLimit();
        $this->resetValues();
    }


    protected function executeQuery(){
        $query=$this->sql;
        if(!empty($this->where)){
            $whereString='';
            foreach ($this->where as $where){
                $whereString .= $where['condition'] . " " . $where['operator'] . " ";
            }
            $whereString=trim($whereString,"AND ");
            $whereString=trim($whereString,"OR ");
            $whereString=trim($whereString," ");
            $query .= " WHERE " . $whereString;
        }

        if(!empty($this->orderBy)){

            $query .= " ORDER BY " . implode(", ",$this->orderBy);
        }

        if(!empty($this->limit)){
            $limitString=$this->limit['from'] . "," .$this->limit['count'];
            $query .= " LIMIT " . $limitString;
        }

        $query .= " ;";
        $pdo=DBConnection::getDBConnectionInstance();
        $stmt=$pdo->prepare($query);
        if(sizeof($this->bindValues) > sizeof($this->values)){
            sizeof($this->bindValues) > 0 ? $stmt->execute($this->bindValues) : $stmt->execute();
        }else{
            sizeof($this->values) > 0 ? $stmt->execute(array_values($this->values)) : $stmt->execute();
        }
        return $stmt;
    }


    protected function getCount(){
        $query="SELECT COUNT(*) FROM " .$this->getTableName();
        if(!empty($this->where)){
            $whereString='';
            foreach ($this->where as $where){
                $whereString .= $where['condition'] . " " . $where['operator'] . " ";
            }
            $whereString=trim($whereString," ");
            $query .= " WHERE " . $whereString;
        }
        $query .= " ;";
        //echo $query;

        $pdo=DBConnection::getDBConnectionInstance();
        $stmt=$pdo->prepare($query);
        if(sizeof($this->bindValues) > sizeof($this->values)){
            sizeof($this->bindValues) > 0 ? $stmt->execute($this->bindValues) : $stmt->execute();
        }else{
            sizeof($this->values) > 0 ? $stmt->execute(array_values($this->values)) : $stmt->execute();
        }
        return $stmt->fetchColumn();
    }

    protected function getTableName(){
        return '`'.$this->table.'`';
    }

    protected function getAttributeName($attribute){
        return '`'.$this->table.'`.`'.$attribute.'`';
    }


}