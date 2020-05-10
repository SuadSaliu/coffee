@extends('layouts.app')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight" style="max-width: 800px">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>@lang('common.user_profile')</h5>
                </div>
                <div class="ibox-content">
					<form action="{{ url('settings/profile') }}" class="form-horizontal" method="POST">
						<input type="hidden" name="_method" value="post">
						{{ csrf_field() }}
			
						<div class="form-group">
							<label class="col-sm-4 control-label" for="name">@lang('common.name')</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
							</div>
						</div>
						<div class="hr-line-dashed"></div>
			
						<div class="form-group">
							<label class="col-sm-4 control-label" for="email">@lang('common.email')</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="email" name="email"
									value="{{ old('email', $user->email) }}">
							</div>
						</div>
						<div class="hr-line-dashed"></div>
			
						@if(Auth::user()->role_id == 1)
						<div class="form-group">
							<label class="col-sm-4 control-label" for="role_id">@lang('common.role')</label>
							<div class="col-sm-8">
								<select class="form-control" id="role_id" name="role_id">
									@foreach($roles as $id => $role)
				
									<option value="{{ $role->id }}"
										{{ !($role->id == old('role_id', $user->role_id)) ?: 'selected="selected"' }}>
										{{ $role->display_name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						@endif
						<div class="hr-line-dashed"></div>
			
						<div class="btn-profile">
							<button type="submit" class="btn btn-primary">@lang('common.update')</button>
							<a class="btn btn-link" href="{{ url('settings/profile') }}">@lang('common.cancel')</a>
							<input type="button" data-toggle="modal" data-target="#resetPasswordModal"
								class="btn btn-primary pull-right" value="@lang('common.reset_password')">
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- resetPasswordModal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">@lang('common.reset_password')</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="font-14px">@lang('common.old_password')</label>
					<input type="password" id="user_password_pass" class="form-control notreadonly">
				</div>
				<div class="form-group">
					<label class="font-14px">@lang('common.new_password')</label>
					<input type="password" id="new_password" class="form-control notreadonly">
				</div>
				<div class="form-group">
					<label class="font-14px">@lang('common.confirm_new_password')</label>
					<input type="password" id="confirm_password" class="form-control notreadonly">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="Update_Password" data-id="pass"
					class="btn btn-primary">@lang('common.update')</button>
			</div>
		</div>
	</div>
</div>
<link href="{{url('assets/css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
<script src="{{url('assets/js/plugins/sweetalert/sweetalert.min.js')}}"></script>

<script>
	$("body").on("click" , "#Update_Password" , function() {
			
			
			
						var form_data = {
							ID_User: $("#ID_User").val(),
							user_password: $("#user_password_pass").val(),
							new_password: $("#new_password").val(),
						};
						var error = false;
						if($("#user_password_pass").val() == "") { 
								$("#user_password_pass").addClass("error");
								error = true;
						} else { 
								$("#user_password_pass").removeClass("error");
						}
						
						if($("#new_password").val() == "") { 
								$("#new_password").addClass("error");
								error = true;
						} else { 
								$("#new_password").removeClass("error");
						}
						
						if($("#confirm_password").val() == "") { 
								$("#confirm_password").addClass("error");
								error = true;
						} else { 
								$("#confirm_password").removeClass("error");
						}
						
						if($("#confirm_password").val() != $("#new_password").val()) { 
							swal({
									  text: "Confirm Password does not match",
									  showCancelButton: true,
									  type: "error",
									  cancelButtonText: "Ok",
									  showConfirmButton: false
									})
									
							return false;
						}
						
							if(error == true) { 
								swal({
									  text: "Required all fields",
									  showCancelButton: true,
									  type: "error",
									  cancelButtonText: "Ok",
									  showConfirmButton: false
									})
							}
						

					$.ajax({
						type: 'POST',
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						url: '<?php echo url("settings/update_password"); ?>',
						data: form_data,
						success: function (msg) {
							$('#resetPasswordModal').modal('hide');
							$('#changeEmailModal').modal('hide');
							var obj = JSON.parse(msg);
							if(obj['error'] == 1) {
									swal({
									  text: obj['message'],
									  showCancelButton: true,
									  type: "error",
									  cancelButtonText: "Ok",
									  showConfirmButton: false
									}).then(
									  function () {},
									  // handling the promise rejection
									  function (dismiss) {
											$('#resetPasswordModal').modal('show');
										
									  }
									)
							}
							
							if(obj['error'] == 0) {
									swal({
									  text: obj['message'],
									  showCancelButton: true,
									  type: "success",
									  cancelButtonText: "Ok",
									  showConfirmButton: false
									}).then(
									  function () {},
									  // handling the promise rejection
									  function (dismiss) {
											location.reload();
									  }
									)
									
								
							}
								
						}
					});

		});
</script>
@endsection