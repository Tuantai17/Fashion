<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Orderdetail extends Model
// {
//     protected $table ='orderdetail';
//     public $timestamps =false;// k co created_at va update_at
// }


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'orderdetail';

    protected $fillable = [
        'order_id',
        'product_id',
        'price_buy',
        'qty',
        'amount',
    ];

    public $timestamps = false; // ✅ thêm dòng này để tránh lỗi updated_at
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    

}