@extends('layouts.app')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>@lang('common.add') @lang('common.bussiness')</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('')}}">@lang('common.home')</a>
            </li>
            <li>
                <a href="{{url('bussiness')}}">@lang('common.bussiness')</a>
            </li>
            <li class="active">
                <strong>@lang('common.add_new')</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight" style="max-width: 800px">
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
                    <form action="{{ url('bussiness') }}" class="form-horizontal" method="POST"
                        enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                        
                        <div class="form-group">
                            <label class="col-sm-5 control-label">@lang('common.name')</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">@lang('common.description')</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="description" name="description"
                                    value="{{ old('description') }}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-12 text-center">

                                <a class="btn btn-white" href="{{ url('bussiness') }}">Cancel</a>
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