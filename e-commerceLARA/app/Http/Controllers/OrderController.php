<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{  
    public function __construct()
    {
        $this->middleware('auth:api');
    }
 

    public function create(Request $request,$idproduct)
    {
        $request->validate([
            'quantity' => 'required',
        ]);
    
        $user=Auth::user();
        $product = Product::find($idproduct);
    
        if ($user && $user->role_name == "User" && $product) {
            $order = Order::create([
                'quantity' => $request->quantity,
                'total' => $request->quantity * $product->price,
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'order' => $order,
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found or does not have the required role, or product not found',
            ]);
        }
    }
    
    
    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {   

        $user=Auth::user();
        if ($user && $user->role_name == "User") {
            $order = Order::where('user_id', $user->id)->get();
        if (!$order) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Order Not Found',
                
            ]);
        }
        else{
            return response()->json([
                'status' => 'success',
                'message' => 'Order Found successfully',
                'product' => $order,
            ]);
        }
    }
}

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user=Auth::user();
        $order = order::find($id);
        if ($order && $user) {
            $order->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Order deleted successfully',
                'product' => $order,
            ]);
            }
            else{
                return response()->json([
                    'status' => 'success',
                    'message' => 'Not Found',

            ]);
            }
         
    }
}