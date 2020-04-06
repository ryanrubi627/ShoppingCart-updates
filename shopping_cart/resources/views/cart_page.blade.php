<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--CSRF Token-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Styles-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--JQuery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!--Bootstrap-->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<!--Data table-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
	<a class="navbar-brand" onclick="window.location='{{ url("/user_page") }}'">Back</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">

        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
<br><br>
@if(Session::exists('cart_item'))

<div class="container-fluid">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="card">
				<h5 class="card-header">Cart</h5>
				<div class="card-body">
					<table class="table table-bordered table-hover myTable" style="table-layout: fixed;">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name of Item</th>
								<th>Description</th>
								<th>quantity</th>
								<th>Price</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						{{-- {{ dd(Session::get('cart_item')) }} --}}
						@foreach(Session::get('cart_item') as $cart_item)
							<tr>
								<td>{{ $cart_item[0]['id'] }}</td>
								<td>{{ $cart_item[0]['nameofitem'] }}</td>
								<td>{{ $cart_item[0]['description'] }}</td>
								<td>{{ $cart_item[0]['quantity'] }}</td>
								<td>{{ $cart_item[0]['price'] }}</td>
								<td>
									<a href="#" class="btn btn-primary buy-item">Buy</a>
									<a href="#" class="btn btn-primary remove" id="{{ $cart_item[0]['id'] }}" >Remove</a>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-1">
		</div>
	</div>
</div>
@else
<div class="container-fluid">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="card">
				<h5 class="card-header">Cart</h5>
				<div class="card-body">
					<table class="table table-bordered table-hover myTable" style="table-layout: fixed;">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name of Item</th>
								<th>Description</th>
								<th>quantity</th>
								<th>Price</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-1">
		</div>
	</div>
</div>
@endif
</body>
</html>
<!--------------------------------ADD ITEM MODAL-------------------------------->
<div class="modal fade" id="item_cart_modal" role="dialog">
<div class="modal-dialog">
  <!--Modal content-->
  <div class="modal-content">
    <div class="modal-header">
    <h5 id="h2"></h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h5 name="item_id" id="item_id" hidden></h5>

							<div class="card">
								<img class="card-img-top img_cart_item" alt="Bootstrap Thumbnail First" src="">
								<div class="card-block" style="margin:20px">
									<center><i id="i2"></i><br><br>
									<p id="quantity_avail"></p></center>
									<hr>
									<input type="number" class="form-control prc" id="item_cart_quantity" maxlength="2" hidden/>
									Quantity:<input type="number" class="form-control prc" id="cart_quantity" maxlength="2" disabled/>
									Price:<input type="number" class="form-control prc" id="item_cart_price" disabled/>
									Total:<input type="number" class="form-control prc" id="item_cart_result" disabled/><br>
									<button type="button" style="float:right;"class="btn btn-primary" id="buy_item">Check Out</button>
								</div>
							</div>

				</div>
			</div>
		</div>
    </div>
  </div>  
</div>
</div>
<!------------------------------------------------------------------------------>

<script>
$(document).ready(function(){

	//DATA TABLE..
    $('.myTable').DataTable();

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });  

    //RETRIEVING ITEM_ID FROM TABLE..
	$('.buy-item').on('click', function(){
		$('#item_cart_modal').modal('show');

		let tr = $(this).closest('tr');

		let data = tr.children("td").map(function(){
			return $(this).text();
		}).get();

		$('#item_id').text(data[0]);
		$('#cart_quantity').val(data[3]);

		let item_id = $('#item_id').text()

		$.ajax({
           type:'POST',
           url:'/cart_page/item_id',
	       data:{
	       		item_id:item_id
	       },
           success:function(data){
           		$('#quantity_avail').text(data.quantity+' pcs available');
           		$('#h2').text(data.nameofitem);
           		$('#i2').text(data.description);
           		$('#item_cart_quantity').val(data.quantity);
           		$('#item_cart_price').val(data.price);
           		$(".img_cart_item").attr('src', '/images/'+data.image); 
           }
        });

	});


	//COMPUTATION OF QUANTITY & PRICE..
	function comp(){
		let quantity = $('#cart_quantity').val();
		let item_price = $('#item_cart_price').val();

		let result = quantity * item_price;
		let item_result = $('#item_cart_result').val(result);
	}
	$("#buy_item").mouseenter(function() {
        comp();
    });

    $('#buy_item').on('click', function(){

    	let id = $('#item_id').text();
		let item_quantity = $('#item_cart_quantity').val();
		let quantity = $('#cart_quantity').val();

		let result_quantity = item_quantity - quantity;

		// if(quantity == item_quantity || quantity < item_quantity){
		// 	alert('Successfully purchase this item');
		// }else {
		// 	alert('Out of stock');
		// 	return false;
		// }

        $.ajax({
           type:'post',
           url:'/cart_page/quantity_update',
           data:{
           		id:id,
           		result_quantity:result_quantity
           },
           success:function(){
           		alert('Successfully purchase this item');
           		$('#item_cart_modal').modal('hide');
	        	location.reload(true);
	        }
		});
	});

	//REMOVE DATA FROM CART
	$('.remove').on('click', function(){
		var id = this.id;

		var delete_confirmation = confirm("Are you sure you want to delete this?");
	    if(delete_confirmation == true){
	        alert('Successfuly Deleted Item');

		    $.ajax({
		       type:'get',
		       url:'/cart/remove',
		       data:{
		       		id:id
	       	   },
	       	   success:function(data){
	       	   		location.reload(true);
		        }

	       	});
	    }
	});
});
</script>
