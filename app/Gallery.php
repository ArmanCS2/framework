<?php

namespace App;
require_once realpath(__DIR__ . '/../system/Database/ORM/Model.php');
use System\Database\ORM\Model;
use System\Database\Traits\HasSoftDelete;

class Gallery extends Model{
    use HasSoftDelete;
    protected $table='galleries';
    protected $fillable=['image','advertise_id'];
    protected $deletedAt='deleted_at';

    public function ad(){
        return $this->belongsTo('\App\Ads','advertise_id','id');
    }

}