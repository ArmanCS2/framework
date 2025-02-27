<?php

namespace App;
require_once realpath(__DIR__ . '/../system/Database/ORM/Model.php');

use System\Database\ORM\Model;
use System\Database\Traits\HasSoftDelete;

class Ads extends Model
{
    use HasSoftDelete;

    protected $table = 'ads';
    protected $fillable = ['title', 'description', 'address', 'amount', 'image', 'floor', 'year', 'storeroom', 'balcony', 'area', 'room', 'toilet', 'parking',
        'tag', 'status', 'user_id', 'cat_id', 'sell_status', 'type', 'view'];
    protected $deletedAt = 'deleted_at';

    public function galleries()
    {
        return $this->hasMany('\App\Gallery', 'advertise_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('\App\Category', 'cat_id', 'id');
    }

    public function sellStatus()
    {
        return $this->sell_status == 1 ? 'اجاره' : 'خرید';
    }

    public function balcony()
    {
        return $this->balcony == 1 ? 'دارد' : 'ندارد';
    }

    public function type()
    {
        switch ($this->type) {
            case 0:
                return 'آپارتمان';
            case 1:
                return 'ویلایی';
            case 2:
                return 'زمین';
            case 3:
                return 'سوله';
        }
    }
}