<?php

namespace App\Models;

use App\Models\User;

use App\Models\Store;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id', 'user_id', 'payment_method', 'status', 'payment_status',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }

    public function products()
    {
        // انه هاد الجدول الوسيط وانت بترجعلي بيانات البرودكت رجعلي كمان بيانات وحقول الي موجودة بالجدول الوسيط الخاصة فيه
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class)
            ->as('order_item')
            ->withPivot([
                'product_name', 'price', 'quantity', 'options',
            ]);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }


    // billingAddress رجعلي بس ال
    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', '=', 'billing');

        //return $this->addresses()->where('type', '=', 'billing');
    }


    // shippingAddress رجعلي 
    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', '=', 'shipping');
    }

    // public function delivery()
    // {
    //     return $this->hasOne(Delivery::class);
    // }

    // هاد انه يعملي ارقام لرقم الاوردر زي الارقام العشوائية
    protected static function booted()
    {
        static::creating(function(Order $order) {
            // 20220001, 20220002
            $order->number = Order::getNextOrderNumber();
        });
    }

    // بس بدي ياه انه يبدا الرقم حسب رقم السنة
    public static function getNextOrderNumber()
    {
        // SELECT MAX(number) FROM orders
        $year =  Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}


