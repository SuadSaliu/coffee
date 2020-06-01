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
                <strong>@lang('common.update')</strong>
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
                    <h5>@lang('common.update')</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="{{ url('bussiness/' . $bussiness->id) }}" class="form-horizontal" method="POST">
                        <input type="hidden" name="_method" value="put">
                        {{ csrf_field() }}
                        <input type="hidden" name="userId" value="{{ Auth::user()->id }}">

                        <div class="form-group">
                            <label class="col-sm-5 control-label" for="name">@lang('common.name')</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $bussiness->name) }}">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-5 control-label">@lang('common.description')</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="description" name="description"
                                    value="{{ old('description', $bussiness->description) }}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group text-center">
                            <a class="btn btn-link" href="{{ url('bussiness') }}">@lang('common.cancel')</a>
                            <button type="submit" class="btn ml-2 btn-primary">@lang('common.update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
