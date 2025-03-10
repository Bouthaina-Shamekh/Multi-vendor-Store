<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;

class CartController extends Controller
{
    protected $cart;


//    هلقيت الكنترولر بيقرا من كارت سيرفسس بروفايدر 
//    بدي من كارت سيرفسس كود الكارد ريبوزتري 
//    وحطلي كود الكارت ريبوزتي بكل فانكشن جوا الكنترولر 
//    ف بدل م اضل اكرر كود كارت ريبوزتري الي جوا الكارت سيرفسس تم عمل فانكشن الكونستركتور 
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.cart', [
            'cart' => $this->cart,
        ]);
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
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        // $repository = new CartModelRepository();
        $this->cart->add($product, $request->post('quantity'));

        if ($request->expectsJson()) {
            
            return response()->json([
                'message' => 'Item added to cart!',
            ], 201);
        }
        
        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['required', 'int', 'min:1'],
        ]);
        // $repository = new CartModelRepository();
        $this->cart->update($id, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->cart->delete($id);
        
        return [
            'message' => 'Item deleted!',
        ];
    }
}
