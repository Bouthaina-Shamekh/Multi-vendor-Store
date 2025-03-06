<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
  {
     //بدل هاد الكود تم تنفيذ القلوبل سكوب
    // $user = Auth::user();
    //         if($user->store_id){
    //           $products = Product::where('store_id','=','$user->store_id')->paginate();

    //     }
    //     else{
    //  $products = Product::paginate();
    // }

    $products = Product::with(['category', 'store'])->paginate();
        // SELECT * FROM products
        // SELECT * FROM categories WHERE id IN (..)
        // SELECT * FROM stores WHERE id IN (..)
    return view('dashboard.products.index', compact('products'));
  }

  public function create()
    {
        $product =  new Product();
        return view('dashboard.products.create', compact('product'));
        // $this->authorize('create', Product::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->authorize('create', Product::class);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        // $this->authorize('view', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        // $this->authorize('update', $product);

        $tags = implode(',', $product->tags()->pluck('name')->toArray());

        return view('dashboard.products.edit', compact('product', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // $this->authorize('update', $product);

        $product->update( $request->except('tags') );


        // $tags = json_decode($request->post('tags'));
        $tags = json_decode($request->post('tags'), true);
        // $tag_ids = [];
        if (!is_array($tags)) {
            $tag_ids = []; // تعيين مصفوفة فارغة في حالة الفشل
        }

        $saved_tags = Tag::all();

        foreach ($tags as $item) {
            dd($item);
            $slug = Str::slug($item->value);
            $tag = $saved_tags->where('slug', $slug)->first(); //جاب ب السلق لانه بكونش فيه زوائد او فراغات او اي اشي 
            if (!$tag) {
                $tag = Tag::create([
                    'name' => $item->value,
                    'slug' => $slug,
                ]);
            }
            $tag_ids[] = $tag->id;
        }

        // هنا بتخزن بعلاقات الماني تو ماني باستخدام السينك
        $product->tags()->sync($tag_ids);

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // $this->authorize('delete', $product);
    }
}
