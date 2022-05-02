<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product as ModelsProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class Product extends Controller
{
    public function Index()
    {
        $Info = ModelsProduct::get();
        return response()->json([
            'status' => 200,
            'product' => $Info,
        ]);
    }
    //
    public function Index2()
    {
        $Info = ModelsProduct::where('status', 1)->get();
        return response()->json([
            'status' => 200,
            'product' => $Info,
        ]);
    }

    public function Store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50|unique:categories,name',
            'img' => 'required|image',
            'shipping' => 'required | max:50',
            'category' => 'required | max:50',
            'ship_cost' => 'required | max:50',
            'details' => 'required | max:50',
            'ship_time' => 'required | max:50',
            'cost' => 'required | max:6| min:1',
            'size' => 'required | max:10',
            'qty' => 'required | max:4',
            'color' => 'required | max:50',
            'brand' => 'required | max:50',
            // 'meta' => 'required | max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validator_errors' => $validator->errors(),
            ]);
        } else {
            $Stroeproduct = new ModelsProduct;
            $Stroeproduct->name = $request->input('name');
            $Stroeproduct->shipping = $request->input('shipping');
            $Stroeproduct->category_id = $request->input('category');
            $Stroeproduct->ship_cost = $request->input('ship_cost');
            $Stroeproduct->details = $request->input('details');
            $Stroeproduct->ship_time = $request->input('ship_time');
            $Stroeproduct->cost = $request->input('cost');
            $Stroeproduct->size = $request->input('size');
            $Stroeproduct->qty = $request->input('qty');
            $Stroeproduct->color = $request->input('color');
            $Stroeproduct->brand = $request->input('brand');
            $Stroeproduct->meta_title = $request->input('meta');
            $Stroeproduct->meta_key = $request->input('meta_key');
            $Stroeproduct->meta_details = $request->input('meta_details');
            $Stroeproduct->featured = $request->input('featured');
            $Stroeproduct->popular = $request->input('popular');
            $Stroeproduct->status = 0;
            $image = $request->file('img');
            $extened = $image->getClientOriginalExtension();
            $image_name = time() . '.' . $extened;
            $image->move('uploads/product/', $image_name);
            $Stroeproduct->pic = 'uploads/product/' . $image_name;
            $Stroeproduct->save();
            return response()->json([
                'status' => 200,
                'message' => 'product Created Successfully',
            ]);
        }
    }

    public function Edit($id)
    {
        $edit_product = ModelsProduct::find($id);
        if ($edit_product) {
            return response()->json([
                'status' => 200,
                'product' => $edit_product,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Product Found',
            ]);
        }
    }

    public function Update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50|unique:categories,name',
            'pic' => 'required|image',
            'shipping' => 'required | max:50',
            'category' => 'required | max:50',
            'ship_cost' => 'required | max:50',
            'details' => 'required | max:50',
            'ship_time' => 'required | max:50',
            'cost' => 'required | max:6| min:1',
            'size' => 'required | max:10',
            'qty' => 'required | max:4',
            'color' => 'required | max:50',
            'brand' => 'required | max:50',
            // 'meta' => 'required | max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validator_errors' => $validator->errors(),
            ]);
        } 
        else {

            $Stroeproduct = ModelsProduct::find($id);


            if ($Stroeproduct) {

                $Stroeproduct->name = $request->input('name');
                $Stroeproduct->shipping = $request->input('shipping');
                $Stroeproduct->category_id = $request->input('category');
                $Stroeproduct->ship_cost = $request->input('ship_cost');
                $Stroeproduct->details = $request->input('details');
                $Stroeproduct->ship_time = $request->input('ship_time');
                $Stroeproduct->cost = $request->input('cost');
                $Stroeproduct->size = $request->input('size');
                $Stroeproduct->qty = $request->input('qty');
                $Stroeproduct->color = $request->input('color');
                $Stroeproduct->brand = $request->input('brand');
                $Stroeproduct->meta_title = $request->input('name');
                // $Stroeproduct->meta_key = $request->input('meta_key');
                $Stroeproduct->meta_details = $request->input('details');
                // $Stroeproduct->featured = $request->input('featured');
                // $Stroeproduct->popular = $request->input('popular');
                // $Stroeproduct->status = $request->input('status');
    
                if ($request->hasFile('image')) {
                    # code...
                    $path = $Stroeproduct->pic;
                    if (File::exsits($path)) {
                        # code...
                        File::delete($path);
                    }
                }
                $image = $request->file('pic');
                $extened = $image->getClientOriginalExtension();
                $image_name = time() . '.' . $extened;
                $image->move('uploads/product/', $image_name);
                $Stroeproduct->pic = 'uploads/product/' . $image_name;
                $Stroeproduct->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'product Updated Successfully',
                ]);
            } 
            else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Plese Input Correct Info ',
                ]);
            }
        }
    }


    public function Destroy($id)
    {
        $product = ModelsProduct::find($id);
        if ($product) {
            $product->status = 1;
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
    
    public function Restore($id)
    {
        $product = ModelsProduct::find($id);
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
}
