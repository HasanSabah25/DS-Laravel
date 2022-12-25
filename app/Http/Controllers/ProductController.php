<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use DataTables;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /*** API functions ***/

    public function indexApi()
    {
            $products=Product::all();
            return response()->json([
            'products'=>$products
            ],200);
    }
    public function storeApi(Request $request)
    {
        try {
            $validateProduct = Validator::make($request->all(),
            [
                'productname' => 'required|String',
                'productprice' => 'required|numeric',
                'productquantity' => 'required|numeric'
            ]);

            if($validateProduct->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateProduct->errors()
                ], 401);
            }

             Product::create([
                'product_name'=> $request->productname,
                'product_price' => $request ->productprice,
                'product_quantity' =>$request->productquantity
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Product Added Successfully',
                // 'token' => $product->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function updateApi(Request $request,$id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json([
                'message'=>'Product Not Found.'
                ], 404);
            }
            $validateProduct = Validator::make($request->all(),
            [
                'productname' => 'required|String',
                'productprice' => 'required|numeric',
                'productquantity' => 'required|numeric'
            ]);

            if($validateProduct->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateProduct->errors()
                ], 401);
            }
             Product::whereId($id)->update([
                'product_name'=> $request->productname,
                'product_price' => $request ->productprice,
                'product_quantity' =>$request->productquantity
            ]);

                return response()->json([
                'status' => true,
                'message' => 'Product Updated Successfully'
                ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroyApi($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
            'message'=>'Product Not Found.'
            ], 404);
        }
        $product->delete();
        return response()->json([
        'message'=>'Product Deleted Successfully'
        ],200);
    }

    /*** End Of API functions ***/

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Product::select('id', 'product_name', 'product_price', 'product_quantity')->get();
                return Datatables::class::of($data)->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= ' <button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                return $button;
                })
                ->make(true);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $rules = array(
        'productname' => 'required',
        'productprice' => 'required',
        'productquantity' => 'required'
        );
        $error = Validator::class::make($request->all(), $rules);
        if ($error->fails()) {
            return response ()->json(['errors' =>$error->errors()->all()]);
        }
        $formData= array(
            'product_name'=> $request->productname,
            'product_price' => $request ->productprice,
            'product_quantity' =>$request->productquantity
        );
        Product::create($formData);
        return response ()->json (['success' => 'Data Added successfully. ']);
    }
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data=Product::findOrFail($id);
            return response()->json(['result'=> $data]);
        }
    }
    public function update(Request $request)
    {
        $rules = array(
            'productname' => 'required',
            'productprice' => 'required',
            'productquantity' => 'required'
        );
        $error = Validator::class::make($request->all(), $rules);
            if ($error->fails()) {
                return response ()->json(['errors' =>$error->errors()->all()]);
            }
            $formData=array(
                'product_name'=> $request->productname,
                'product_price' => $request ->productprice,
                'product_quantity' =>$request->productquantity
            );
        Product::whereId($request->hidden_id)->update($formData);
        return response ()->json (['success' => 'Data is successfully Updated. ']);
    }
    public function destroy($id){
        $data=Product::findOrFail($id);
        $data->delete();
    }
}

