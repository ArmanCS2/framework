<?php

namespace System\Database\Traits;

trait HasRelation
{
    protected function hasOne($model, $foreign_key, $local_key)
    {
        if (isset($this->properties[$this->primary_key])) {
            $object = new $model();
            return $object->getHasOneRelation($this->table, $foreign_key, $local_key, $this->$local_key);
        }
    }

    public function getHasOneRelation($table, $foreign_key, $other_key, $other_key_value)
    {
        $this->setSql("SELECT `b`.* FROM `{$table}` AS `a` JOIN " . $this->getTableName() . " AS `b` ON `a`.`{$other_key}`=`b`.`{$foreign_key}`");
        $this->setWhere("`a`.`{$other_key}`=?", 'AND');
        $this->addValue($other_key, $other_key_value);
        $this->table = 'b';
        $statement = $this->executeQuery();
        $data = $statement->fetch();
        if ($data) {
            return $this->arrayToAttributes($data);
        }
        return null;
    }


    protected function hasMany($model, $foreign_key, $local_key)
    {
        if ($this->{$this->primary_key}) {
            $object = new $model();
            return $object->getHasManyRelation($this->table, $foreign_key, $local_key, $this->$local_key);
        }
    }

    public function getHasManyRelation($table, $foreign_key, $other_key, $other_key_value)
    {
        $sql="SELECT `b`.* FROM `{$table}` AS `a` JOIN " . $this->getTableName() . " AS `b` ON `a`.`{$other_key}`=`b`.`{$foreign_key}`";
        $this->setSql($sql);
        $this->setWhere("`a`.`{$other_key}`=?", 'AND');
        $this->addValue($other_key, $other_key_value);
        $this->table = 'b';
        return $this;
    }

    protected function belongsTo($model, $foreign_key, $local_key)
    {
        if ($this->{$this->primary_key}) {
            $object = new $model();
            return $object->getBelongsToRelation($this->table, $foreign_key, $local_key, $this->$foreign_key);
        }
    }

    public function getBelongsToRelation($table, $foreign_key, $other_key, $foreign_key_value)
    {
        $sql="SELECT `b`.* FROM `{$table}` AS `a` JOIN " . $this->getTableName() . " AS `b` ON `a`.`{$foreign_key}`=`b`.`{$other_key}`";
        $this->setSql($sql);
        $this->setWhere("`a`.`{$foreign_key}`=?", 'AND');
        $this->addValue($foreign_key, $foreign_key_value);
        $this->table = 'b';
        $statement = $this->executeQuery();
        $data = $statement->fetch();
        if ($data) {
            return $this->arrayToAttributes($data);
        }
        return null;
    }

    protected function belongsToMany($model, $foreign_key, $local_key, $commonTable, $middleForeinKey, $middleRelation)
    {
        if ($this->{$this->primary_key}) {
            $object = new $model();
            return $object->getBelongsToManyRelation($this->table, $foreign_key, $local_key, $this->$local_key, $commonTable, $middleForeinKey, $middleRelation);
        }
    }

    public function getBelongsToManyRelation($table, $foreign_key, $other_key, $other_key_value, $commonTable, $middleForeignKey, $middleRelation)
    {
        $this->setSql("SELECT `c`.* FROM 
                  (SELECT `b`.* FROM `{$table}` AS `a` JOIN `{$commonTable}` AS `b` ON `a`.`{$other_key}`=`b`.`{$middleForeignKey}` WHERE `a`.`{$other_key}` = ?)
                AS `relation` JOIN " . $this->getTableName() . " AS `c` ON `relation`.`{$middleRelation}`=`c`.`$foreign_key`");
        $this->addValue("{$table}_{$other_key}", $other_key_value);
        $this->table = 'c';
        return $this;
    }
}