<?php

namespace App;
require_once realpath(__DIR__ . '/../system/Database/ORM/Model.php');
use System\Database\ORM\Model;
use System\Database\Traits\HasSoftDelete;

class Slide extends Model{
    use HasSoftDelete;
    protected $table='slides';
    protected $fillable=['title','url','address','amount','body','image'];
    protected $deletedAt='deleted_at';
}