<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class Frontend extends Controller
{
    //
    public function Collect()
    {
        $category = Category::where('status', 0)->get();
        return response()->json([
            'status' => 200,
            'category' => $category,
        ]);
    }

    public function SubCollect($slug)
    {
        $category = Category::where('name', $slug)->where('status', 0)->first();

        if ($category) {
            $product = Product::where('category_id', $category->id)->where('status', 0)->get();
            if ($product) {
                return response()->json([
                    'status' => 200,
                    'product' => $product,
                    'category' => $category,

                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'category' => "No Data Avialable",
            ]);
        }
    }

    public function ItemCollect($cateory, $product)
    {
        $category = Category::where('name', $cateory)
        ->where('status', 0)
         ->first();

        if ($category) {
            $product = Product::where('category_id', $category->id)
            ->first()
            ->where('name', $product)
            ->where('status', 0)
            ->get();
            if ($product) {
                return response()->json([
                    'status' => 200,
                    'product' => $product,
                    'category' => $category,

                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'category' => "No Data Avialable",
            ]);
        }
    }

    public function AddToCart($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->status = 0;
            $product->save();
            return response()->json([
                'status' => 200,
                'message' => 'product Deleted Successfully',
            ]);
        } 
        else {
            return response()->json([
                'status' => 404,
                'message' => 'Try Again Later',
            ]);
        }
        
        
    }

    // public function Update(Request $request, $id)
    // {

    //         $Stroeproduct = ModelsProduct::find($id);


    //         if ($Stroeproduct) {

    //             $Stroeproduct->name = $request->input('name');
    //             $Stroeproduct->shipping = $request->input('shipping');
    //             $Stroeproduct->category_id = $request->input('category');
    //             $Stroeproduct->ship_cost = $request->input('ship_cost');
    //             $Stroeproduct->details = $request->input('details');
    //             $Stroeproduct->ship_time = $request->input('ship_time');
    //             $Stroeproduct->cost = $request->input('cost');
    //             $Stroeproduct->size = $request->input('size');
    //             $Stroeproduct->qty = $request->input('qty');
    //             $Stroeproduct->color = $request->input('color');
    //             $Stroeproduct->brand = $request->input('brand');
    //             $Stroeproduct->meta_title = $request->input('name');
    //             // $Stroeproduct->meta_key = $request->input('meta_key');
    //             $Stroeproduct->meta_details = $request->input('details');
    //             // $Stroeproduct->featured = $request->input('featured');
    //             // $Stroeproduct->popular = $request->input('popular');
    //             // $Stroeproduct->status = $request->input('status');
    
    //             if ($request->hasFile('image')) {
    //                 # code...
    //                 $path = $Stroeproduct->pic;
    //                 if (File::exsits($path)) {
    //                     # code...
    //                     File::delete($path);
    //                 }
    //             }
    //             $image = $request->file('pic');
    //             $extened = $image->getClientOriginalExtension();
    //             $image_name = time() . '.' . $extened;
    //             $image->move('uploads/product/', $image_name);
    //             $Stroeproduct->pic = 'uploads/product/' . $image_name;
    //             $Stroeproduct->save();
    //             return response()->json([
    //                 'status' => 200,
    //                 'message' => 'product Updated Successfully',
    //             ]);
    //         } 
    //         else {
    //             return response()->json([
    //                 'status' => 404,
    //                 'message' => 'Plese Input Correct Info ',
    //             ]);
    //         }
        
    // }

}
