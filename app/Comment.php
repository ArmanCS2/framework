<?php

namespace App;
require_once realpath(__DIR__ . '/../system/Database/ORM/Model.php');
use System\Database\ORM\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['user_id', 'post_id', 'comment', 'status', 'approved', 'parent_id'];

    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');

    }

    public function children()
    {
        return $this->hasMany('\App\Comment', 'parent_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo('\App\Post', 'post_id', 'id');
    }

    public function approved()
    {
        return $this->approved == 0 ? 'تایید نشده' : 'تایید شده';
    }
}