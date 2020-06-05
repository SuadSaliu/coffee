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
							<h5>@lang('pos.order_list') <span id="TableNo"> </span></h5>
						</div>
						<div class="ibox-content" id="car_items" style="padding: 5px;">
							<div class="cart-table-wrap">

								<table width="100%" border="0" style="border-spacing: 5px; border-collapse: separate;"
									class="">

									<tbody id="CartHTML">

									</tbody>

								</table>
							</div>

						</div>
						
					</div>

					<div class="ibox-content" style="padding-bottom: 0px;">

						<div class="row">
							<div class="col-sm-6 col-md-12 col-lg-12">

								<div class="checkbox">
									<label><input id="pushCheckbox" type="checkbox"></label>
									@lang('pos.send_push_notification')
								</div>

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
			<div class="ibox float-e-margins orders">
				
			</div>
		</div>
	</div>
</div>

<style type="text/css">
	.order_list {
		display: flex;
		flex-direction: column;
		padding-top: 16px !important;
		padding-bottom: 16px !important;
	}

	.order_list .form-group:last-child {
		margin-bottom: 0;
	}

	.order_list .text-left {
		padding-left: 0 !important;
	}

	.float-e-margins .btn {
		margin-bottom: 0 !important;
	}

	.checkbox {
		display: flex;
		align-items: center
	}

</style>

<script type="text/javascript">

	$( document ).ready(function() {

		// Get all orders
		onGetOrders();
		setInterval(() => {
			onGetOrders();
		}, 10000);
	});

	function onGetOrders() {
		$.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            },
            url: '<?php echo url("waiting_orders/orders"); ?>',
            data: null,
            success: function ( obj ) {

                var html = "";
                $.each(obj , function(key,value) { 
                    html += `
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="widget white-bg text-center order_list order-${value.id} h-100">
						
							<div class="form-group">
								<label class="col-sm-6 control-label">Table name</label>
								<div class="col-sm-6 text-left" id="table_name">${ value.table_name || '' }</div>
							</div>

							<div class="form-group">
								<label class="col-sm-6 control-label">Customer name</label>
								<div class="col-sm-6 text-left" id="name">${ value.name || 'Website user' }</div>
							</div>

							<div class="form-group">
								<label class="col-sm-6 control-label">Time of the order</label>
								<div class="col-sm-6 text-left" id="date">${ value.updated_at || '' }</div>
							</div>

							<div>
								<button type="button" data-id="${value.id}" id="order-btn" class="btn btn-primary">@lang('pos.addToList')</button>
							</div>

						</div>
					</div>`;
                });
                $(".orders").html(html);
            }
        });
	}

	$("body").on("click","#order-btn", function() {
		const id = $(this).attr("data-id");
		const elm = $('.order-' + id);
		const cname = elm.find('#name').text();

		const html = `<tr id="${id}">
			<td width="10" valign="top">
				<a class="text-danger DeleteItem" data-id="${id}"><i class="fa fa-trash"></i></a></td>
			<td>
				<h4 style="margin:0px;">
					${elm.find('#table_name').text()} ${cname ? ' | ' + cname : ''}
				</h4>
			</td>
			<td width="24%" class="text-right">${elm.find('#date').text()}</td>
		</tr>`;

		if ($(`#CartHTML tr#${id}`).length > 0) {
			toastr.warning( 'Already exists to order list.' )
			return;
		}

		$('#CartHTML').append(html);
		toastr.success( 'Successfully added to order list' )

	});

	$("body").on("click",".DeleteItem", function() {
		const id = $(this).attr("data-id");

		$(`#CartHTML tr#${id}`).remove();
		toastr.error( 'Successfully removed to order list' );
	});

	$("body").on("click","#holdOrders", function() {
		if ($('#CartHTML tr').length === 0) {
			return;
		}

		const ids = [];
		$('#CartHTML tr').each(function(k, el) {
			ids.push($(el).attr("id"));
		});

		$.ajax({
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
				},
				url: '<?php echo url("waiting_orders/hold_orders"); ?>',
				data: {
					ids: ids,
					push_notif: $('#pushCheckbox').is(':checked')
				},
				success: function ( msg ) {
					onGetOrders();
					$("#CartHTML").html('');
				}
			});
	});


</script>

@endsection
