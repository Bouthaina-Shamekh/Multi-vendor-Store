<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('category')) {
            return Gate::allows('categories.update');
        }
        return Gate::allows('categories.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        // هاد اسم الباراميتر الي هيكون برابط الاديت 
        // كيف عرف انه اسمه كاتوجري من الامر 
        // r:l
        
        $id = $this->route('category');

        return Category::rules($id);
    }
}
