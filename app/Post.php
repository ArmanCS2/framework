<?php

namespace App;
require_once realpath(__DIR__ . '/../system/Database/ORM/Model.php');
use System\Database\ORM\Model;
use System\Database\Traits\HasSoftDelete;

class Post extends Model{
    use HasSoftDelete;
    protected $table='posts';
    protected $fillable=['title','body','cat_id','image','published_at','status','user_id'];
    protected $casts=['image'=>'array'];
    protected $deletedAt='deleted_at';

    public function category(){
        return $this->belongsTo('\App\Category','cat_id','id');
    }

    public function user(){
        return $this->belongsTo('\App\User','user_id','id');
    }

    public function comments(){
        return $this->hasMany('\App\Comment','post_id','id');
    }
}
