<?php

namespace App\Models;

use App\Rules\Filter;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'parent_id', 
        'description',
        'image',
        'status',
        'slug',
    ];


    // 'parent_id', 
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')
            ->withDefault([
                'name' => '-'
            ]); 
    }

    // 'parent_id', 
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }


//شرط يكون اول كلمة بالفانكشن سكوب ثم اسم السكوب وعند الاستدعاء فقط نستدعي اسم السكوب بدون كلمة سكوب
    public function scopeActive(Builder $builder)
    {
      $builder->where('status' ,'=' ,'active');
    }

    public function scopeFilter(Builder $builder ,$filters)
    {

      if($filters['name'] ?? false)
      {
        $builder->where('name', 'like', "%{$filters['name']}%");
      }
      if($filters['status'] ?? false)
      {
        $builder->where('status', '=', $filters['status']);
      }
    }


    public static function rules($id = 0)
    {
         return[
        'name' => [

          'required',
          'string',
          'min:3',
          'max:255',
          Rule::unique('categories', 'name')->ignore($id),
        //  new Filter(['php','laravel']),
          'filter:laravel,php,css' // بعد م تم تعريفها بالبروفايدر


        ],
       
        
      'parent_id' => [
        'nullable' , 'int' , 'exists:categories,id'
      ],
      'image' => 'required',
      'status' => 'required|in:active,archived',
    ];
    }

}
