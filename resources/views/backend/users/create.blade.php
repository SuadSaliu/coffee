@extends('layouts.app')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>@lang('common.add') @lang('common.user')</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('')}}">@lang('common.home')</a>
            </li>
            <li>
                <a href="{{url('users')}}">@lang('common.users')</a>
            </li>
            <li class="active">
                <strong>@lang('common.add_new')</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight" style="max-width: 1000px">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>@lang('common.add_new')</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="{{ url('users') }}" class="form-horizontal" method="POST"
                        enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-4 control-label">@lang('common.name')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">@lang('common.email')</label>
                            <div class="col-sm-8"><input type="text" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="role_id">@lang('common.role')</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="role_id" name="role_id">
                                    @foreach($roles as $id => $role)
                                    <option value="{{ $role->id }}"
                                        {{ !($role->id == old('role_id')) ?: 'selected="selected"' }}>
                                        {{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="bussiness_id">@lang('common.bussiness')</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="bussiness_id" name="bussiness_id">
                                    <option value="null"></option>
                                    @foreach($bussiness as $id => $bus)
                                    <option value="{{ $bus->id }}"
                                        {{ !($bus->id == old('bussiness_id')) ?: 'selected="selected"' }}>
                                        {{ $bus->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="bussiness_role">@lang('common.bussinessRole')</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="bussiness_role" name="bussiness_role">
                                    <option value="null"></option>
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                </select>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="password">@lang('common.password')</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"
                                for="password_confirmation">@lang('common.confirm_password')</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group">
                            <div class="col-12 text-center">

                                <a class="btn btn-white" href="{{ url('users') }}">Cancel</a>
                                <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection