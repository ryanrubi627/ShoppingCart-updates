<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cart;
use App\item;
use Session;

class cart_page extends Controller
{
  public function index(Request $request){
    //   $cart_item = cart::all();
		  // return view('cart_page', ['cart_items'=>$cart_item]);
    // $cart_item = $request->session()->get('cart');
    return view('cart_page');
	}

  public function insert_cart_item(Request $request){

      $cart = new cart();
      $cart->nameofitem = $request->name;
      $cart->item_id = $request->id;
      $cart->description = $request->description;
      $cart->quantity = $request->quantity;
      $cart->price = $request->price;
      $cart->save();

  }

  public function delete_cart_item($id){
    cart::where('id', $id)->delete();
    return redirect('/cart_page');
  }

  //DISPLAY ITEM TO MODAL OF CART_PAGE..
  public function display_item(Request $request){

    $id = $request->item_id;
    $item_id = item::where('id', $id)->first();
    return response()->json($item_id);
  }

  public function quantity_update(Request $request){
    $id = $request->id;
    $result_quantity = $request->result_quantity;

    item::where('id', $id)
                  ->update(['quantity' => $result_quantity]);

    $cart_item = session()->get('cart_item');
    foreach($cart_item as $key){
      if($key[0]['id'] == $id){
        session()->forget('cart_item.'.$id);
      }
    }
  }

  public function remove(Request $request){
    $id= $request->id;

    $cart_item = session()->get('cart_item');
    foreach($cart_item as $key){
      if($key[0]['id'] == $id ){
        session()->forget('cart_item.'.$id);
      }
    }

  }

}
