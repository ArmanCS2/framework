<?php

namespace System\Database\Traits;

trait HasAttributes
{
    protected function arrayToObjects(array $array)
    {
        $collection = [];
        foreach ($array as $value) {
            $object = $this->arrayToAttributes($value);
            array_push($collection, $object);
        }
        $this->collection = $collection;
    }

    protected function arrayToAttributes(array $array, $object = null)
    {
        if (!$object) {
            $className = get_called_class();
            $object = new $className;
        }
        foreach ($array as $attribute => $value) {
            if ($this->inHiddenAttributes($attribute)) {
                continue;
            }
            $this->registerAttribute($object, $attribute, $value);


        }
        return $object;

    }

    private function registerAttribute($object, string $attribute, $value)
    {
        $this->inCastAttributes($attribute) == true ? $object->$attribute = $this->castDecodeValue($attribute, $value) : $object->$attribute = $value;
    }

    private function inCastAttributes($attribute)
    {
        return in_array($attribute, array_keys($this->casts));
    }

    private function inHiddenAttributes($attribute)
    {
        return in_array($attribute, $this->hidden);
    }

    private function castDecodeValue($attribute, $value)
    {
        if ($this->casts[$attribute] == 'array' || $this->casts[$attribute] == 'object') {
            return unserialize($value);
        }
        return $value;
    }

    private function castEncodeValue($attribute, $value)
    {
        if ($this->casts[$attribute] == 'array' || $this->casts[$attribute] == 'object') {
            return serialize($value);
        }
        return $value;
    }

    private function arrayToCastEncodeValue($values)
    {
        $newArray = [];

        foreach ($values as $attribute => $value) {
            $this->inCastAttributes($attribute) == true ? $newArray[$attribute] = $this->castEncodeValue($attribute,$value) : $newArray[$attribute] = $value;
        }

        return $newArray;
    }
}