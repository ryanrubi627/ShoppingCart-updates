<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\item;
use Session;

class user_page extends Controller
{
    public function index(){
    	// session('cart_item')
		// $item = item::where('id', '!=', 24)->get();
		$item = item::all();
		return view('user_page', ['items'=>$item]);
	}

	public function show_item(Request $request){
		$item_id = item::find($request->id);
		return response()->json($item_id);
	}

	public function quantity_update(Request $request){
		$id = $request->id;
		$result_quantity = $request->result_quantity;

		item::where('id', $id)
                  ->update(['quantity' => $result_quantity]);
	}

	public function cart_item(Request $request){
		$item_id = item::find($request->id);
		return response()->json($item_id);
		// $item = ['id' => $request->id,
		// 		 'nameofitem' => $request->name,
		// 		 'description' => $request->description,
		// 		 'price' => $request->price];

		// Session::push('cart_item', $item);

		// return $item;
	}


	public function store_to_session_cart(Request $request){
		$item = ['id' => $request->id,
				 'nameofitem' => $request->name,
				 'description' => $request->description,
				 'quantity' => $request->quantity,
				 'price' => $request->price];

		if(session::exists('cart_item')){
			$cart_id = $request->session()->get('cart_item');
			$check = false;

			foreach($cart_id as $key){

				if($key[0]['id'] != $request->id){
					Session::push('cart_item.'.$request->id, $item);
					$check = true;
				}
			}

		}else{
			Session::push('cart_item.'.$request->id, $item);
			$check = true;
		}
		if($check == false){
			return "Item is already added ";
		}else {

		return "Add to cart successfuly";
		}
	}
}
