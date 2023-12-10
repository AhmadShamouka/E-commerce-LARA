<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {  
        $user=Auth::user();
        $products = Product::all();
        return response()->json([
            'status' => 'success',
            '$products' => $products,
        ]);
    }

    
    public function create(Request $request)
    {   
        $user=Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required',
            'quantity' => 'required',
        ]);
    
        if ($user && $user->role_name == "Seller") {

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }
    
       
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'user_id' => $user->id,
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
            'product' => $product,
        ]);
    }
    else {
        return response()->json([
            'status' => 'failed',
            'message' => 'User not found or does not have the required role',
        ]);
    }

    }


    /**
     * Display the specified resource.
     */
    public function show(Product $products, $idproduct)
    {
        $user=Auth::user();
    
        if ($user && $user->role_name == "User") {
            $product = Product::find($idproduct);
    
            if ($product) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Product found successfully',
                    'product' => $product,
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product not found',
                ]);
            }
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found or does not have the required role',
            ]);
        }
    }
    



    public function update(Request $request,$idproduct)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required',
            'quantity' => 'required',
        ]);
    
        $user=Auth::user();
        $product = Product::find($idproduct);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();
        if (!$product || !$user) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Product Not Found',
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully',
                'product' => $product,
            ]);
        }
    }
    public function delete($idproduct)
    {
        $user=Auth::user();
        $product = Product::find($idproduct);
        if (!$product || !$user) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully',
                'product' => $product,
        ]);
    }else{
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
            'product' => $product,
       
        ]);
    }

    }
}