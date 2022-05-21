<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(){
        $this->middleware("auth:sanctum",['except'=>["store"]]);
    }
    
    public function index()
    {
        try{
            $product = Product::all();
            return response()->json([
                "success" => true,
                "product" => $product

            ]);
        }catch (\Exception $e) {

            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);

        }
    }


    public function create()
    {
        
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'price' => 'required',
                'status' => 'required'
            ]);

            $product = Product::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'status' => $request->status
            ]);

            return response()->json([
                "success" => true,
                "product" => $product
            ]);
        }catch (\Exception $e) {

            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);

        }
    }


    public function show($productId)
    {
        try{
            $product = Product::find($productId);

            return response()->json([
                "success" => true,
                "product" => $product
            ]);
        }catch (\Exception $e) {

            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);

        }
    }


    public function edit(Product $product)
    {
        
    }


    public function update(Request $request,$productId)
    {
        try{

            $product = Product::find($productId);

            $product->update($request->all());

            return response()->json([
                "success" => true,
                "product" => $product
            ]);

        }catch (\Exception $e) {

            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);

        }
    }


    public function destroy($productId)
    {
        try{

            $product = Product::find($productId)->delete();
            return response()->json([
                "success" => true,
                "message" => "Product Delete Success !"
            ]);

        }catch (\Exception $e) {

            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);

        }
        
    }
}
