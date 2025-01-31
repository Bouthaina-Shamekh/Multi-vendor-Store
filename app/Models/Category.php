<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'parent_id', 
        'description',
        'image',
        'status',
        'slug',
    ];


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
