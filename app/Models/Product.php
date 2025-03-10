<?php

namespace App\Models;


use Illuminate\Support\Str;
use App\Models\Scopes\StoreScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'category_id', 'store_id',
        'price', 'compare_price', 'status',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,     // Related Model
            'product_tag',  // Pivot table name
            'product_id',   // FK in pivot table for the current model
            'tag_id',       // FK in pivot table for the related model
            'id',           // PK current model
            'id'            // PK related model
        );
    }


    // هاد قلوبل سكوب بدي استخدمه ع كل الموقع انه كل واحد يشوف الداتا الخاصة بالستور تاعته
    protected static function booted()
    {
        //عمل سكوب وراح استدعاها هنا
         static::addGlobalScope('store', new StoreScope());

        // static::creating(function(Product $product) {
        //     $product->slug = Str::slug($product->name);
        // });

    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }


    // Accessores 
    // يتم تعريفه بهذا الشكل الشكل 
    // get.....Attribute
    // في المنتصف اسمه الاكسسيسور 
    
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }


    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return round(100 - (100 * $this->price / $this->compare_price), 1);
    }
    
}
