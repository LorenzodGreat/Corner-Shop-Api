<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart as ModelsCart;
use App\Models\Product;
use Illuminate\Http\Request;

class Cart extends Controller
{
    //
    public function AddToCart(Request $request)
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $product_id = $request->product_id;
            $product_qty = $request->product_qty;
            
            $productCheck = Product::where('id', $product_id)->first();
            if ($productCheck) {
                if (ModelsCart::where('product_id', $product_id)->where('user_id', $user_id)->exists()) {
                    return response()->json([
                        'status' => 409,
                        'message' => $productCheck->name . 'Already in cart',
                    ]);
                } 
                else 
                {
                    $cartItem = new Cart;
                    $cartItem->user_id = $user_id;
                    $cartItem->product_id = $product_id;
                    $cartItem->product_qty = $product_qty;
                    $cartItem->save();
                    return response()->json([
                        'status' => 201 ,
                        'message' => 'I am in cart',
                    ]);
                }
            } 
            else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Product Not Found',
                ]);
            }
        }
         else
          {
            return response()->json([
                'status' => 401,
                'message' => 'Login to Add to cart',
            ]);
            # code...
        }
    }
}
