<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index', 'show');
    }

    public function index(Request $request)
    {
        // return  Product::filter($request->query())
        // ->with('category:id,name', 'store:id,name', 'tags:id,name') 
        //     ->paginate();

        $products = Product::filter($request->query())
        ->with('category:id,name', 'store:id,name', 'tags:id,name') 
            ->paginate();
            
            return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:active,inactive',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);


        // هاي بشكل تلقائي بترجعي رقم 201 
        // return Product::create($request->all());

        $product = Product::create($request->all());

        // لوكيشن عبار عن هيدر بدي ارجعو مع الريسبونس 
        return Response::json($product, 201, [
            'Location' => route('products.show', $product->id),
        ]);

            //  صلاحيات الapi
        // $user = $request->user();
        // if (!$user->tokenCan('products.create')) {
        //     abort(403, 'Not allowed');
        // }

        



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // هادي كويري بيلدر بنفع عشا اجيب العلاقات منها اكتب with
        // $product = Product::findOrFail($id);

        // اما هاي من المودل ف لما بدي اجيب العلاقات معها بستخدم load 
        // هاتلي من العلاقة id و name

        return new ProductResource($product);
        
        return $product
            ->load('category:id,name', 'store:id,name', 'tags:id,name');
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
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'status' => 'in:active,inactive',
            'price' => 'sometimes|required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);

        // $user = $request->user();
        // if (!$user->tokenCan('products.update')) {
        //     abort(403, 'Not allowed');
        // }

        $product->update($request->all());


        return Response::json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return response()->json ([
                     'message' => 'Product deleted successfully',
                     
                 ], 204);

    //     $user = Auth::guard('sanctum')->user();
    //     if (!$user->tokenCan('products.delete')) {
    //         return response([
    //             'message' => 'Not allowed'
    //         ], 403);
    //     }

    //     Product::destroy($id);
    //     return [
    //         'message' => 'Product deleted successfully',
    //     ];
    }
}
