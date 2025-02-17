@extends( 'layouts.app' )
@section( 'content' )
<?php $currency =  setting_by_key("currency");
//ALTER TABLE `customers`  ADD `neighborhood` VARCHAR(255) NULL;
//ALTER TABLE `customers` ADD `comments` VARCHAR(255) NULL;
 ?>
<link href="{{url('assets/css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
<link href="{{url('assets/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
<script src="{{url('assets/js/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{url('assets/js/plugins/sweetalert/sweetalert.min.js')}}"></script>
<div class="wrapper wrapper-content animated fadeInRight">

	<div class="row">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
			<div class="row">
				<div class="col-sm-12">

					<div class="ibox" style="margin-bottom: 0px;">
						<div class="ibox-title">
							<h5>@lang('pos.cart_items') <span id="TableNo"> </span></h5>
						</div>
						<div class="ibox-content" id="car_items" style="padding: 5px;">
							<div class="cart-table-wrap">

								<table width="100%" border="0" style="border-spacing: 5px; border-collapse: separate;"
									class="">

									<tbody id="CartHTML">

									</tbody>

								</table>
							</div>
							<hr>
							<table width="100%" border="0" style="border-spacing: 5px; border-collapse: separate;"
								class="">

								<tbody>

									<tr>

										<td>

											<h4>@lang('pos.sub_total')</h4>

										</td>

										<td class="text-right">

											<h4 id="p_subtotal">0.00</h4>

										</td>
									</tr>
									<!--<tr>

										<td>

											<h4>@lang('pos.discount')</h4>

										</td>

										<td class="text-right">

											<h4 id="p_discount">0.00</h4>

										</td>
									</tr> -->
									<tr>

										<td>

											<h4>@lang('pos.tax')(<?php echo setting_by_key("vat"); ?>%)</h4>

										</td>

										<td class="text-right">

											<h4 id="p_hst">0.00</h4>

										</td>
									</tr>

									<tr>
										<td colspan=2>
											<select id="OrderType" class="form-control">
												<option value="pos">@lang('online_orders.order_store')</option>
												<option value="order">@lang('online_orders.order_home')</option>
											</select>
										</td>
									</tr>
									<input type="hidden" id="OrderType" value="pos">
									<tr>
										<td> <strong> Include Vat </strong></td>
										<td>
											<select id="VatInclude" class="form-control">
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
									</tr>


								</tbody>

							</table>

						</div>
						<div class="panel-footer green-bg">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<td>

											<h4><strong>@lang('pos.total')</strong></h4>

										</td>
										<td class="text-right ">

											<h4 class="TotalAmount">0</h4>

										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="ibox-content" style="padding-bottom: 0px;">
						<div class="row">
							<div class="col-sm-6 col-md-12 col-lg-6">
								<div class="form-group">
									<button type="button" id="Checkout"
										class="btn btn-primary btn-block text-center">@lang('pos.checkout')</button>
								</div>
							</div>
							<div class="col-sm-6 col-md-12 col-lg-6">
								<div class="form-group">
									<button type="button" id="ClearCart"
										class="btn btn-danger btn-block text-center">@lang('pos.clear_cart')</button>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 col-md-12 col-lg-12">
								<div class="form-group">
									<button type="button" id="holdOrders"
										class="btn btn-success btn-block text-center">@lang('pos.hold_tables')</button>
								</div>
							</div>

						</div>

					</div>

				</div>

			</div>
		</div>
		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
			<div class="ibox float-e-margins">
				<div class="ibox-title" style="margin-bottom: 10px;">
					<div class="toolbar mb2 mt2">
						<button class="btn fil-cat" href="" data-rel="all">@lang('common.all')</button>
						@foreach($categories as $category)
						<button class="btn fil-cat" data-rel="{{$category->id}}">{{ $category->name }}</button>
						@endforeach
					</div>
				</div>
				<!--	<div class="ibox-content m-b-sm border-bottom">

                <div class="row">

                    <div class="col-sm-12">

                        <div class="form-group">

                            <input type="text" id="product_name" name="product_name" value="" placeholder="Search" class="form-control">

                        </div>

                    </div>
                </div>
            </div> -->

				<div class="row" id="portfolio">

					@foreach($products as $product)

					<div class="col-xs-12 col-sm-4 col-md-6 col-lg-3 {{$product->category_id}} all">
						<div class="widget white-bg text-center product_list h-100">
							@if(file_exists('uploads/products/' . $product->id . '.jpg'))
							<img loading="lazy" width="100px" alt="image" class="img-circle"
								src="{{url('uploads/products/thumb/' . $product->id . '.jpg')}}">
							<h2 class="m-xs heading-size_image">{{$product->name}}</h2> @else
							<img loading="lazy" width="100px" alt="image" class="img-circle" src="{{url('herbs/noimage.jpg')}}">
							<h2 style="padding-left:5px; text-align:left" class="m-xs heading-size_image">
								{{$product->name}}</h2> @endif
							<?php $prices = json_decode($product->prices); $titles = json_decode($product->titles);?>
							@foreach($titles as $key=>$t)
							<button data-price="{{$prices[$key]}}" data-id="{{$product->id}}" data-key="{{$key}}"
								data-size="{{$t}}" data-name="{{$product->name}} ({{$t}})" type="button"
								class="btn btn-sm btn-primary m-r-sm AddToCart tag-margin tag-btn">{{ $t }}
								{{$prices[$key]}} €</button>
							@endforeach
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">

	<div class="modal-dialog">

		<div class="modal-content animated bounceInRight confirm-modal">

			<div class="modal-header">

				<?php /*?><button type="button" class="close" data-dismiss="modal"><span
						aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php */?>
				<h4 style="float:left; color:red" id="TableNoCart"></h4>
				<h4 class="modal-title" id="total_amount_model">0.00</h4>
			</div>

			<div class="modal-body clearfix">

				<input type="hidden" id="cashier_id" class="form-control" value="{{Auth::user()->id}}">
				<input type="hidden" id="vat" class="form-control" value="0.00">
				<input type="hidden" id="delivery_cost" class="form-control" value="0">
				<input type="hidden" id="total_amount" class="form-control" value="0">
				<input type="hidden" id="customer_id" class="form-control" value="">

				<input type="hidden" id="payment_type" class="form-control" value="Cash">


				<div class="col-sm-12">

					<p class="text-center">@lang('pos.how_would_you_pay')</p>

				</div>

				<div class="col-sm-3 col-sm-offset-3">

					<div class="form-group text-center">

						<div data-id="Cash" class="payment-option-icon text-success">

							<i class="fa fa-money fa-4x"></i>

						</div>

					</div>

				</div>

				<div class="col-sm-3">

					<div class="form-group text-center">

						<div data-id="Card" class="payment-option-icon">

							<i class="fa fa-credit-card fa-4x"></i>

						</div>

					</div>

				</div>
				<div class="clearfix"></div>

				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" id="total_given" placeholder="@lang('pos.total_paid')"
							class="form-control numberPad">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" id="change" readonly placeholder="@lang('pos.change')" class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<select class="form-control" id="table_id">
							@foreach ($tables as $table)
							<option value="{{$table->id}}">{{$table->table_name}}</option>
							@endforeach

						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<textarea id="comments" placeholder="@lang('pos.comment')" class="form-control"></textarea>
					</div>
				</div>

				<div class="col-sm-12 text-right">
					<button type="button" class="btn btn-warning" id="holdOrder">@lang('pos.hold_order')</button>
					<button type="button" class="btn btn-white" data-dismiss="modal">@lang('pos.close')</button>
					<input type="hidden" value="" id="id" />
					<button type="button" id="completeOrder"
						class="btn btn-primary">@lang('pos.complete_order')</button>
				</div>

			</div>

		</div>

	</div>

</div>



<div class="modal inmodal" id="myHoldOrderModal" tabindex="-1" role="dialog" aria-hidden="true">

	<div class="modal-dialog">

		<div class="modal-content animated bounceInRight confirm-modal">

			<div class="modal-header">
				<h4 class="modal-title" id="total_amount_model">@lang('pos.hold_tables')</h4>
			</div>
			<input type="hidden" id="holdOrderID">
			<div class="modal-body clearfix">
				<div id="HoldOrdersList"> </div>
			</div>

		</div>

	</div>

</div>

<script type="text/javascript">
	$( "body" ).on( "click", "#holdOrders", function () {
			var form_data = {
				id:""
			};
			$.ajax({
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
				},
				url: '<?php echo url("sale/hold_orders"); ?>',
				data: form_data,
				success: function ( msg ) {
					
					var obj = JSON.parse(msg);
					var eachIn = false;
					var html = '<div class="table-responsive"> <table class="table"> <tbody><thead> <tr> <th>@lang('pos.Table No')</th> <th>@lang('pos.order_no')</th> <th>@lang('pos.held_by')</th> <th></th> </tr> </thead><tbody>';
					$.each(obj , function(key,value) {
						eachIn = true; 
						html += `<tr class="holdt">
									<th scope="row">${value.table}</th>
									<td>
										<a href="javascript:void(0)" class="ViewHoldOrder" data-table="${value.table}"
											data-table_id="${value.table_id}" data-id="${value.id}">${value.id}</a></td>
									<td>${value.username}</td>
									<td>
										<a style="color:red" href="javascript:void(0)" data-id="${value.id}"
											class="deleteHoldOrder"><i class="fa fa-trash fa-lg"> </i></a>
									</td>
								</tr>`;
					});
					html += '</tbody></table></div>';

					if(!eachIn) {
						html = "No hold data found";
					}
					$("#HoldOrdersList").html(html);
					$("#myHoldOrderModal").modal("show");
				}
			});
		});

		$( "body" ).on( "click", ".ViewHoldOrder", function () {
			var form_data = {
				id:$(this).attr("data-id")
			}

			$("#holdOrderID").val($(this).attr("data-id"));
			$("#TableNo").text(" (" + $(this).attr("data-table") + ")");
			$("#TableNoCart").text(" (" + $(this).attr("data-table") + ")");
			$("#table_id").val($(this).attr("data-table_id"));
			$.ajax( {
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
				},
				url: '<?php echo url("sale/view_hold_order"); ?>',
				data: form_data,
				success: function ( msg ) {
					cart = JSON.parse(msg);
					show_cart();
					$("#myHoldOrderModal").modal("hide");
				}
			});


		});
		$( "body" ).on( "click", "#holdOrder", function () {
			var form_data = {
				id:$("#holdOrderID").val(),
				table_id:$("#table_id").val(),
				comment:$("#comments").val(),
				cart:cart,
			};
			$.ajax( {
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
				},
				url: '<?php echo url("sale/hold_order"); ?>',
				data: form_data,
				success: function ( msg ) {
					location.reload();
					$.each( cart, function( key, value ) {
						deleteItemFromCart(value);
						
					});
					show_cart();
					$("#myModal").modal("hide");
				}
			});
		});



$("body").on("click","#Checkout", function() {
	if ($('#CartHTML tr').length === 0) { return; }
	var OrderType = $("#OrderType").val();
	if(OrderType == "order") { 
		$("#myModalHome").modal("show");
	} else { 
		$("#myModal").modal("show");
	}
});

$("body").on("keyup" , "#mobile_number", function(e) {
	var phone = $("#mobile_number").val();
	if(phone.length < 7) { 
		return false;
	}
	
  $.getJSON("findcustomer?phone=" + $("#mobile_number").val(),
        function(data) {
			if(data) { 
				$("#full_name").val(data['name']);
				//$("#phone").val(data['mobile_number']);
				$("#address_c").val(data['address']);
				$("#email").val(data['email']),
				$("#neighborhood").val(data['neighborhood']);
				$("#comments_c").val(data['comments']);
				$("#id").val(data['id']);
				$("#Client").html("@lang('pos.is_former_client')");
			} else { 
				$("#Client").html("@lang('pos.is_new_client')");
				$("#id").val("");
			}
			
        });
});



$("body").on("click",".deleteHoldOrder", function() {
	$(this).parent().parent(".holdt").remove();
	
	var form_dataa = {
		id:$(this).attr("data-id")
	}
	$.ajax( {
		type: 'POST',
		headers: {
			'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
		},
		url: '<?php echo url("sale/hold_order_remove"); ?>',
		data: form_dataa,
		success: function ( msg ) {
			
		}
	});
				
});


</script>

<div class="modal inmodal" id="myModalHome" tabindex="-1" role="dialog" aria-hidden="true">

	<div class="modal-dialog">

		<div class="modal-content animated bounceInRight confirm-modal">

			<div class="modal-header">
				<h4 class="modal-title" id="total_amount_model">@lang('pos.customer_information')</h4>
			</div>

			<div class="modal-body clearfix">

				<div class="col-sm-12">
					<div class="form-group">
						<input type="text" id="mobile_number" placeholder="@lang('pos.mobile_number')"
							class="form-control numberPad">
					</div>
				</div>

				<div class="col-sm-12">
					<div class="form-group">
						<h3 id="Client" style="text-align:center">Is a new client/is a former client</h3>
					</div>
				</div>


				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" id="full_name" placeholder="@lang('pos.full_name')" class="form-control ">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" id="address_c" placeholder="@lang('pos.address')" class="form-control">
					</div>
				</div>

				<div class="col-sm-12">
					<div class="form-group">
						<input type="text" id="email" placeholder="@lang('pos.email')" class="form-control ">
					</div>
				</div>

				<div class="col-sm-12">
					<div class="form-group">
						<input type="text" id="comments_c" placeholder="@lang('pos.comment')" class="form-control">
					</div>
				</div>

				<div class="col-sm-12 ">
					<span id="errorMessage" style="color:red"> </span>
				</div>

				<div class="col-sm-12 text-right">
					<button type="button" id="ClearForm" class="btn btn-white">@lang('pos.close')</button>

					<button type="button" id="CustomerNext" class="btn btn-primary">@lang('pos.Next')</button>
					<span id="errorMessage" style="color:red"> </span>
				</div>

			</div>

		</div>

	</div>

</div>

<script type="text/javascript">
	$("body").on("click","#ClearForm", function() {
	$("#full_name").val("");
	$("#neighborhood").val("");
	$("#address_c").val("");
	$("#email").val("");
	$("#comments_c").val("");
	$("#id").val("");
	$("#mobile_number").val("");
	$("#myModalHome").modal("hide");
});
$("body").on("click","#CustomerNext", function() {
	var form_data = {
		name:$("#full_name").val(),
		phone:$("#mobile_number").val(),
		email:$("#email").val(),
		neighborhood:$("#neighborhood").val(),
		address:$("#address_c").val(),
		comments:$("#comments_c").val(),
		id:$("#id").val()
	}
	
	if(!$("#mobile_number").val() || !$("#full_name").val() || !$("#email").val()) { 
		$("#errorMessage").html("@lang('pos.required')");
		return false;
	}
	
	
	$.ajax({
		type: 'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: '<?php echo url("sales/store_customer"); ?>',
		data: form_data,
		success: function (msg) {
			var obj = $.parseJSON(msg);
			if(obj['message'] == "OK") { 
				$("#myModalHome").modal("hide");
				$("#myModal").modal("show");
				$("#customer_id").val(obj['id']);
			}
		},
		error: function() {
			toastr.error( 'Error! The customer exists, or try again later.' );
		}
	});
					
});
</script>



<link rel="stylesheet" href="{{url('assets/numpad/jquery.numpad.css')}}">

<script src="{{url('assets/js/lodash.min.js')}}"></script>

<script src="{{url('assets/numpad/jquery.numpad.js')}}"></script>

<style type="text/css">

	@media screen and (min-width: 768px) {
		/* .wrapper {
			height: calc(67vw - 12em) !important;
		} */

		.wrapper > .row,
		.wrapper > .row .col-xs-12,
		.wrapper > .row .col-xs-12 .ibox {
			height: 100%;
		}
	}

	.nmpd-grid {
		border: none;
		padding: 20px;
	}


	.nmpd-grid>tbody>tr>td {
		border: none;
	}

	/* Some custom styling for Bootstrap */



	.qtyInput {
		display: block;
		width: 100%;
		padding: 6px 12px;
		color: #555;
		background-color: white;
		border: 1px solid #ccc;
		border-radius: 4px;
		webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
		webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
		o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
		transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
	}
</style>
<script>
	$("body").on("click",".payment-option-icon", function() {
		$(".payment-option-icon").removeClass("text-success");
		$(this).addClass("text-success");
		$("#payment_type").val($(this).attr("data-id"));
	});
	$( function () {

		$( ".navbar-minimalize" ).click();

	} );

	$.fn.numpad.defaults.gridTpl = '<table class="table modal-content"></table>';

	$.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in"></div>';

	$.fn.numpad.defaults.displayTpl = '<input type="text" class="form-control" />';

	$.fn.numpad.defaults.buttonNumberTpl = '<button type="button" class="btn btn-default"></button>';

	$.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn" style="width: 100%;"></button>';

	$.fn.numpad.defaults.onKeypadCreate = function () {

		$( this ).find( '.done' ).addClass( 'btn-primary' );

	};
	$( document ).ready( function () {
		$( '.numberPadkk' ).numpad();
	} );

	$( "body" ).on( "keyup", "#total_given", function () {
		var total_amount = $( "#total_amount" ).val();
		var total_given = $( this ).val();
		var change = Number( total_given ) - Number( total_amount );
		$( "#change" ).val( change.toFixed( 2 ) );
	} );
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"progressBar": true,
		"preventDuplicates": false,
		"positionClass": "toast-top-right",
		"onclick": null,
		"showDuration": "400",
		"hideDuration": "1000",
		"timeOut": "2000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}

	var products = new Array();

	var count_items = 0;
	var cart = new Array();
	$( "body" ).on( "click", ".AddToCart", function () {

		count_items++;

		var ids = _.map( cart, 'id' );

		var item = {
			id: $( this ).attr( "data-id" ) + $( this ).attr( "data-key" ),
			product_id: $( this ).attr( "data-id" ),
			price: $( this ).attr( "data-price" ),
			size: $( this ).attr( "data-size" ),
			name: $( this ).attr( "data-name" )
		};

		if ( !_.includes( ids, item.id ) ) {
			item.quantity = 1;
			item.p_qty = 1;
			cart.push( item );
		} else {
			var index = _.findIndex( cart, item );
			cart[ index ].quantity = cart[ index ].quantity + 1
		}

		toastr.success( 'Successfully Added to Cart' )
		show_cart();	
		});
		
		$( "body" ).on( "click", "#ClearCart", function () {
$("#TableNo").text("");
$("#TableNoCart").text("");
		var cart = [];
		$( ".TotalAmount" ).html( 0 );

				$( "#CartHTML" ).html( "" );
		
				$( "#p_subtotal" ).html( "0.00" );

				$( "#p_hst" ).html( "0.00" );

				$( "#p_discount" ).html( "0.00" );
	} );
	$( "body" ).on( "click", ".DecreaseToCart", function () {
		var item = {
			id: $( this ).attr( "data-id" )
		};
		var index = _.findIndex( cart, item );

		if ( cart[ index ].quantity == 1 ) {
			deleteItemFromCart( item );
		} else {
			cart[ index ].quantity = cart[ index ].quantity - 1;
		}
		//console.log(cart[index].quantity);
		//toastr.success('Successfully Updated')       
		show_cart();

	} );

	$( "body" ).on( "click", ".IncreaseToCart", function () {
		var item = {
			id: $( this ).attr( "data-id" )
		};
		var index = _.findIndex( cart, item );
		cart[ index ].quantity = cart[ index ].quantity + 1;
		show_cart();

	} );

	$( "body" ).on( "click", ".DeleteItem", function () {
		var item = {
			id: $( this ).attr( "data-id" )
		};

		deleteItemFromCart( item );
	} );

	$( "body" ).on( "click", ".DiscountItem", function () {

	} );

	function deleteItemFromCart( item ) {
		var index = _.findIndex( cart, item );
		cart.splice( index, 1 );
		show_cart();
	}

	$( "body" ).on( "click", "#completeOrder", function () {

		const totalGivenVal = $( "#total_given" ).val();
		if (!totalGivenVal) {
			toastr.error( 'Total paid is empty' );
			return;
		}

		if ( cart.length < 1 ) {

			$( "#myModal" ).modal( "hide" );

			swal( "", "Cart is Empty", "error" );

			return false;
		}
		$("#TableNo").text("");
		
		var status = 1;
		// if($("#OrderType").val() == "order") { 
		// status = 2;
		// }
		var form_data = {
			comments: $( "#comments" ).val(),
			customer_id: $( "#customer_id" ).val(),
			discount: $( "#discount" ).val(),
			cashier_id: $( "#cashier_id" ).val(),
			payment_with: $( "#payment_type" ).val(),
			type: $( "#OrderType" ).val(),
			status:status,
			total_given: totalGivenVal,
			table_id: parseInt($("#table_id").val(), 10),

			change: $( "#change" ).val(),
			vat: $( "#vat" ).val(),
			delivery_cost: $( "#delivery_cost" ).val(),
			customer_id: $( "#customer_id" ).val(),
			items: _.map( cart, function ( cart ) {
				return {
					product_id: cart.product_id,
					size: cart.size,
					quantity: cart.quantity,
					price: cart.price
				}
			} )
		};
		var total_amount = Number( localStorage.getItem( "total_amount" ) );
		_.map( cart, function ( cart ) {
			localStorage.setItem( "total_amount", total_amount + ( cart.quantity * cart.price ) );
		} );

		$( "#completeOrder" ).html( '<i class="fa fa-spinner fa-spin" style="font-size:18px"></i>' );
		$( "#completeOrder" ).prop( "disabled", true );

		$.ajax( {
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
			},
			url: '<?php echo url("sales/complete_sale"); ?>',
			data: form_data,
			success: function ( msg ) {
				$( "#myModal" ).modal( "hide" );
				cart = [];
				$( "#total_given" ).val( "" );
				$( "#change" ).val( "" );
				$( "#comments" ).val( "" );
				$( "#total_amount_model" ).html( "0.00" );
				$( "#completeOrder" ).html( 'Checkout' );
				$( "#completeOrder" ).prop( "disabled", false );
				
				$("#full_name").val("");
				$("#address_c").val("");
				$("#email").val(""),
				$("#neighborhood").val("");
				$("#comments_c").val("");
				$("#id").val("");

				var form_dataa = {
					id:$("#holdOrderID").val()
				}

				$("#holdOrderID").val("");
				$.ajax( {
					type: 'POST',
					headers: {
						'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
					},
					url: '<?php echo url("sale/hold_order_remove"); ?>',
					data: form_dataa,
					success: function ( msg ) {
						
					}
				});
				
				swal( {
					title: '@lang("pos.order_complete")',
					type: 'success',
					text: ''
				} ).then( function () {

					window.open( msg, "_blank" );

					// if ( Number( localStorage.getItem( "total_amount" ) ) >= 500 ) {

						// swal( "$500 of sales", "Empty the cash drawer", "error" );

						// localStorage.setItem( "total_amount", 0 );

					// }
				} )
				$( "#p_subtotal" ).html( "0.00" );

				$( "#p_hst" ).html( "0.00" );

				$( "#p_discount" ).html( "0.00" );
				show_cart();
			}
		} );
	} );

	$("body").on("change" , "#VatInclude" , function() { 
		show_cart();
	});
	function show_cart() {
		if ( cart.length > 0 ) {
			var qty = 0;
			var total = 0;
			var cart_html = "";
			var obj = cart;
			$.each( obj, function ( key, value ) {
				cart_html += '<tr>';
				cart_html += '<td width="10" valign="top"><a href="javascript:void(0)" class="text-danger DeleteItem" data-id=' + value.id + '><i class="fa fa-trash"></i></a></td>';
				cart_html += '<td><h4 style="margin:0px;">' + value.name + '</h4></td>';
				cart_html += '<td width="80"><span class="btn btn-primary btn-sm text-center IncreaseToCart" data-id=' + value.id + '>+</span> ' + value.quantity + ' <span  class="btn btn-primary btn-sm DecreaseToCart" data-id=' + value.id + '>-</span> </td>';
				cart_html += '<td width="15%" class="text-right"><h4 style="margin:0px;"> <?php echo $currency; ?>' + value.price + '</h4> </td>';
				cart_html += '</tr>';
				qty = Number( value.quantity );
				total = Number( total ) + Number( value.price * qty );
			} );

			var VatInclude = $("#VatInclude").val();
			var vat = 0;
			if(VatInclude == "Yes") { 
				vat = ( Number( total ) * <?php echo setting_by_key("vat"); ?> ) / 100;
			}
			

			$( "#p_subtotal" ).html( "<?php echo $currency; ?>" + total.toFixed( 2 ) );

			$( "#p_hst" ).html( "<?php echo $currency; ?>" + vat.toFixed( 2 ) );
			//// Discount 

			// var discount = 0;

			// if ( Number( count_items ) >= 2 ) {

				// discount = <?php echo setting_by_key('discount'); ?>;

			// }
			// $( "#discount" ).val( discount );

			// $( "#p_discount" ).html( "<?php echo $currency; ?>" + discount.toFixed( 2 ) );
			// cart_html += '<div class="panel-footer"> Total Items' ;
			// cart_html += '<span class="pull-right"> ' + qty ;
			// cart_html += '</span></div>' ;

			var total_amount = Number( total ) + vat;
			$( "#total_amount" ).val( total_amount );
			$( "#total_amount_model" ).html("<?php echo $currency; ?>" + total_amount.toFixed( 2 ) );			
			$( "#vat" ).val( vat );

			$( ".TotalAmount" ).html( "<?php echo $currency; ?>" + total_amount.toFixed( 2 ) );
			$( "#CartHTML" ).html( "" );
			$( "#CartHTML" ).html( cart_html );
		} else {
				$( ".TotalAmount" ).html( 0 );
				$( "#p_subtotal" ).html( "0.00" );
				$( "#total_amount_model" ).html( "0.00" );
				$( "#p_hst" ).html( "0.00" );
				$( "#CartHTML" ).html( "" );
		}
		
		

	}

</script>

<style>
	.cart-item {

		max-height: 160px;

		overflow-y: scroll;

	}



	.scale-anm {

		transform: scale(1);

	}



	.tile {

		-webkit-transform: scale(0);

		transform: scale(0);

		-webkit-transition: all 350ms ease;

		transition: all 350ms ease;

	}



	.tile:hover {}



	.product_list {

		min-height: 240px !important;

		margin-top: 0px;

	}

	.product_list h2 {

		padding: 2px 8px;

		margin-bottom: 8px !important;

		text-align: left;
	}
</style>

<script>
	$( "body" ).on( "click", ".close", function () {
		alert( "close" );
	} );
	$( function () {
		var selectedClass = "";
		$( ".fil-cat" ).click( function () {
			selectedClass = $( this ).attr( "data-rel" );
			$( "#portfolio" ).fadeTo( 100, 0.1 );
			$( "#portfolio > div" ).not( "." + selectedClass ).fadeOut().removeClass( 'scale-anm' );
			setTimeout( function () {
				$( "." + selectedClass ).fadeIn().addClass( 'scale-anm' );
				$( "#portfolio" ).fadeTo( 300, 1 );
			}, 300 );

		} );
	} );

</script>

@endsection