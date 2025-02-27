<?php

namespace App;
require_once realpath(__DIR__ . '/../system/Database/ORM/Model.php');
use System\Database\ORM\Model;
use System\Database\Traits\HasSoftDelete;

class User extends Model
{
    use HasSoftDelete;
    protected $table = 'users';
    protected $fillable = ['email', 'first_name', 'last_name', 'avatar', 'password', 'status', 'is_active', 'verify_token', 'user_type', 'remember_token', 'remember_token_expire','jwt'];
    protected $deletedAt='deleted_at';


}
