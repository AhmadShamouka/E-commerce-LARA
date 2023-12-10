<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCard;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ShoppingCardController extends Controller
{
  

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer',
        ]);
    
        if ($user && $user->role_name == "User") {
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found',
                ], 404);
            }
    
            $product = Product::find($request->id);
            $total_amount = $product->price * $request->quantity;
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found',
                ], 404);
            }
    
            $card = ShoppingCard::create([
                'total_price' => $total_amount,
                'quantity' => $request->quantity,
                'product_id' => $product->id,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'card created successfully',
                'card' => $card,
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found or does not have the required role',
            ]);
        }
    }
    

    public function show(ShoppingCard $shoppingCard)
    {
        if(Auth()->check()){
            $user = Auth::user();
            if($user){
            $user_id = $user->id;
            $card=ShoppingCard::where('id',$user_id)->get();
            if($card){
                      return response()->json([
                      "cards" => $card,
                      "message" => 'successfully'
                  ]);
            }else{
              return response()->json(['No cards found']);
            }
      
      }
    else{
          return response()->json(['message :', 'Unauthorizaed']);
        }
      }
    }



    public function destroy(Request $req)
    {
        if(Auth()->check()){
            $user = Auth::user();
            if($user){
                $card = ShoppingCard::where('user_id', $user->user_id)->latest()->first();
    
                if(!$card || !$req->id){
                    return response()->json(['error' => 'Cannot find card or product']);
                }
                $card_item = ShoppingCard::where('product_id', $req->id)->first();
    
                if(!$card_item){
                    return response()->json(['error' => 'Item not found in the card']);
                }
           
                         $card_item->delete();
    
                         $card->save();
                
                         return response()->json(['message' => 'Item removed from the card']);
       
    
            } else {
                return response()->json(['error' => 'Cannot remove item']);
            }
        } else {
            return response()->json(['error' => 'Unauthorized']);
        }
    }
    }