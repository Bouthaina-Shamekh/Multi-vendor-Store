<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
       public function index(){
   
          $categories = Category::all();

        return view('dashboard.category.index',compact('categories'));
        
       }

       public function create(){

          $parents = Category::all();
         
          return view('dashboard.category.create', compact('parents'));    
       }


       public function store(Request $request){

           //   $request->input('name'); //من ريكويست الget&post
          //    $request->post('name');
          //    $request->name;
          //    $request->get('name');
          //    $request['name'];
          //    $request->query('name'); من رابط url في الفورم
         
          $request->merge([
              'slug' => Str::slug($request->post('name'))
          ]);
          $category = Category::create($request->all());

         return Redirect::route('category.index');         

       }

}
