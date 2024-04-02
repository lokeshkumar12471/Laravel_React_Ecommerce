<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
            'user_id',
          'firstname',
           'lastname',
           'phone',
           'email',
           'address',
           'city',
           'state',
           'zipcode',
           'payment_id',
           'payment_mode',
           'tracking_no',
           'status',
           'remark',
    ];

       protected $with = ['orderitems'];
        public function orderitems(){
        return $this->hasMany(OrderItem::class,'order_id','id');
    }
}
