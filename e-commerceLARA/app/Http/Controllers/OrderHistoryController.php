<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
class OrderHistoryController extends Controller
{
    
    public function create()
    {
        $user = Auth::user();
        
        if ($user && $user->role_name == "User") {
            $totalAmount = Order::where('user_id', $user->id)->sum('total');
            $order=Order::find($user->id);
           
            OrderHistory::create([
                'total_amount' => $totalAmount,
                'user_id' => $user->id,
                'order_id' => $order->id,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Order history created successfully',
                'total_amount' => $totalAmount,
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found or does not have the required role',
            ]);
        }
    }
    

        public function show(OrderHistory $orderHistory)
        {
            $user=Auth::user();
            if ($user && $user->role_name == "User") {
                $order = OrderHistory::where('user_id', $user->id)->get();
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
    }