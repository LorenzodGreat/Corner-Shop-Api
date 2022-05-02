<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category as ModelsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class Category extends Controller
{
    //
    public function Index()
    {
        $Info = ModelsCategory ::all();
        return response()->json([
            'status' => 200,
            'category' => $Info,
        ]);
    }



    public function Store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50|unique:categories,name',
            'img' => 'required|image',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validator_errors' => $validator->errors(),
            ]);
        } else {
            $StroeCategory = new ModelsCategory;
            $StroeCategory->name = $request->input('name');
            $image = $request->file('img');
            $extened = $image->getClientOriginalExtension();
            $image_name = time() . '.' . $extened;
            $image->move('uploads/category/', $image_name);
            $StroeCategory->img = 'uploads/category/' . $image_name;
            $StroeCategory->save();
            return response()->json([
                'status' => 200,
                'message' => 'Category Created Successfully',
            ]);
        }
    }

    public function Edit($id)
    {
        $edit_category = ModelsCategory::find($id);
        if ($edit_category) {
            return response()->json([
                'status' => 200,
                'category' => $edit_category,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Category Found',
            ]);
        }
    }

    public function Update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:40',
            'img' => 'required|image'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validator_errors' => $validator->errors(),
            ]);
        } 
        else {

            $StroeCategory = ModelsCategory::find($id);

            if ($StroeCategory) {

                $StroeCategory->name = $request->input('name');
                if ($request->hasFile('image')) {
                    # code...
                    $path = $StroeCategory->img;
                    if (File::exsits($path)) {
                        # code...
                        File::delete($path);
                    }
                }
                $image = $request->file('img');
                $extened = $image->getClientOriginalExtension();
                $image_name = time() . '.' . $extened;
                $image->move('uploads/category/', $image_name);
                $StroeCategory->img = 'uploads/category/' . $image_name;
                $StroeCategory->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Category Updated Successfully',
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
        $category = ModelsCategory::find($id);
        if ($category) {
            $category->status = 1;
            $category->save();
            return response()->json([
                'status' => 200,
                'message' => 'Category Deleted Successfully',
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
        $category = ModelsCategory::find($id);
        if ($category) {
            $category->status = 0;
            $category->save();
            return response()->json([
                'status' => 200,
                'message' => 'Category Restored Successfully',
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
