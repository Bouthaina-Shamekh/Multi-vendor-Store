<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
  public function index()
  {

    if (!Gate::allows('categories.view')) {
      abort(403);
  }

    $request = Request();
    // $query = Category::query();
    // if($name = $request->query('name') )
    // {
    //   $query->where('name', 'like', "%{$name}%");
    // }
    // if($status = $request->query('status') )
    // {
    //   $query->where('status', '=', $status);
    // }

    // $categories = Category::all();
    $categories = Category::with('parent')
    // هات البرودكت الي تابعة لكل كاتوجري اسم هاد العمود سميته برودكت نيم
    // ->withCount('products as products_number')
    ->withCount([
      'products as products_number' => function($query) {
          $query->where('status', '=', 'active');
      }
  ])
    ->filter($request->query())->paginate(5);
    //$categories = Category::active()->paginate(2);
    return view('dashboard.category.index', compact('categories'));
  }

  public function create()
  {

    $parents = Category::all();
    $category = new Category();

    return view('dashboard.category.create', compact('parents', 'category'));
  }


  public function store(Request $request)
  {
    //   $request->input('name'); //من ريكويست الget&post
    //    $request->post('name');
    //    $request->name;
    //    $request->get('name');
    //    $request['name'];
    //    $request->query('name'); من رابط url في الفورم


    // $request->validate([
    //   'name' => 'required|string|min:3|max:255',
    //   'parent_id' => [
    //     'nullable' , 'int' , 'exists:categories,id'
    //   ],
    //   'image' => 'required',
    //   'status' => 'in:active,archived',

    // ]);

    $clean_data = $request->validate(Category::rules(), [
      'required' => 'This Faild (:attribute) is required ya بثينة الامورة',
      'unique' => 'this name is already exist'
    ]);



    $request->merge([
      'slug' => Str::slug($request->post('name'))
    ]);


    // $data = $request->except('image');
    // if($request->hasFile('image')){
    //   $file = $request->file('image'); // upload obj
    //   $path = $file->store('uploads',[
    //     'disk' => 'public'
    //   ]);
    //   $data ['image'] = $path;
    // }

    $data = $request->except('image');
    $data['image'] = $this->uploadImgae($request);

    $category = Category::create($data);

    return Redirect::route('category.index')->with('success', 'Category created!');
  }


  public function show(Category $category)
    {
       
        return view('dashboard.category.show', [
            'category' => $category
        ]);
    }


  public function edit($id)
  {

    $category = Category::findOrFail($id);
    //رجعلي كل البارنت عدا البارنت تاعتها 
    $parents = Category::where('id', '<>', $id)
      ->where(function ($query) use ($id) {
        $query->whereNull('parent_id')
          ->orWhere('parent_id', '<>', $id);
      })
      ->get();
    return view('dashboard.category.edit', compact('category', 'parents'));
  }

  public function update(CategoryRequest $request, $id)
  {

    // $request->validate(Category::rules($id));
    $category = Category::findOrFail($id);

    $old_image = $category->image;

    $data = $request->except('image');

    $data = $request->except('image');
    $new_image = $this->uploadImgae($request);
    if ($new_image) {
      $data['image'] = $new_image;
    }

    $category->update($data);

    if ($old_image && $new_image) {
      Storage::disk('public')->delete($old_image);
    }


    // $new_image = $this->uploadImgae($request);
    //   if ($request->hasFile('image')){
    //     $file = $request->file('image');
    //     $path =  $file->store('uploads' ,[
    //         'disk' => 'public'
    //     ]);
    //     $data['image'] = $path;
    // }



    //$category->fill($request->all())->save();

    //حذف الصورة القديمة

    if ($old_image && isset($data['image'])) {
      Storage::disk('public')->delete($old_image);
    }

    $category->update($request->all());

    return Redirect::route('category.index');
  }

  public function destroy($id)
  {
    $category = Category::findOrFail($id);
    $category->delete();

    // if($category->image){
    //   Storage::disk('public')->delete($category->image);
    // }
    return redirect()->route('category.index')->with('success', __('Item deleted successfully.'));
  }

  protected function uploadImgae(Request $request)
  {
    if (!$request->hasFile('image')) {
      return;
    }

    $file = $request->file('image'); // UploadedFile Object

    $path = $file->store('uploads', [
      'disk' => 'public'
    ]);
    return $path;
  }

  public function trash()
  {

    $categories = Category::onlyTrashed()->paginate();
    return view('dashboard.category.trash', compact('categories'));
  }

  public function restore($id)
  {

    $category = Category::onlyTrashed()->findOrFail($id);
    $category->restore();

    return redirect()->route('category.trash')
      ->with('succes', 'Category restored!');
  }

  public function forcedelete($id)
  {
    $category = Category::onlyTrashed()->findOrFail($id);
    $category->forceDelete();

    if ($category->image) {
      Storage::disk('public')->delete($category->image);
    }

    return redirect()->route('category.trash')
      ->with('success', 'Category deleted forever!');
  }
}
