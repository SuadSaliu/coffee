<style type="text/css">
	/*@import url("https://fonts.googleapis.com/css?family=Roboto");*/
	body {
		/*font-family: 'Roboto', sans-serif;*/
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
		font-size: 15px;
		line-height: 1.5;
	}
	.report-title-bg {
		padding: 5px;
		background-color: #18A689;
		color: #fff;
		font-size: 15px;
	}
	.pdf-footer p {
		margin: 0px;
		padding: 10px 0;
		border-top: #000 1px solid;
		font-size: 9px;
	}
	.m-tb0 {
		margin-top: 0px !important;
		margin-bottom: 0px !important;
	}
	.m-b0 {
		margin-bottom: 0px !important;
	}
</style>

<style>
	
	.table-stats {
		margin-top: 5px;
		font-size:13px;
	}
	.table-stats, .table-stats th, .table-stats td {
		border: #000 1px solid;
	}
	.table-stats thead {
		background-color: #d81921;
		text-align: left;
		color: #FFF;
	}
	.table-stats th, .table-stats td {
		padding: 3px 5px;
	}
	.table-stats tbody tr:nth-child(even) {
		background-color: #EEE;
	}
	
	.pdf-footer {
		position: fixed;
		left: 0px;
		bottom: 0px;
		width: 100%;
	}
	
</style>
<style>
	
	
		@page {
			size: portrait;
			/*margin-left: 1%;
			margin-right: 1%;*/
		}
	
	
	.table-stats tfoot th {
		background-color: #afb0d8;
		text-align: center;
	}
	.table-stats tfoot tr th:first-child {
		background-color: #21409a;
		color: #FFF;
		text-align: right;
	}
	
</style>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td style="background-color: #18A689; padding: 15px 20px;">
				<span style="float: right;margin-top: 10px; color: #FFF;">As of: {{date("m/d/Y")}}</span>
				<img loading="lazy" src="uploads/logo.jpg" alt="">
			</td>
		</tr>
		
		<?php /*?><tr>
			
				<td align="right">As of: {{date("m/d/Y")}}</td>

		</tr><?php */?>
		<tr>
		</tr>
	</tbody>
</table><br>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-stats" >
	<thead>
			<tr>
        <th>@lang('common.title')</th>
        <th>@lang('common.qrCode')</th>
			</tr>
		</thead>
		<tbody>
			<?php $total_amount = 0; ?>
			@foreach($tables as $table) 
			<tr>
				<td>{{$table->table_name}}</td>
				<td>
					
					@if (!$table->bussiness_id)
					<img loading="lazy" width="100" alt=""
              			src="uploads/qr/table-{{$table->id}}.png" class="img-responsive">
					@else
					<img loading="lazy" width="100" alt=""
						  src="uploads/qr/{{$table->bussiness_id}}/table-{{$table->id}}.png" class="img-responsive">
					@endif
					
				</td>
			</tr>
			@endforeach
		</tbody>
</table>

<br><br>

<div class="pdf-footer">
	<p>Created by {{Auth::user()->name}} on {{date("m/d/Y")}}.</p>
</div>
