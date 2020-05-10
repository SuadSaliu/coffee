@extends('layouts.app')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>@lang('pos.tables')</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('/')}}">@lang('common.home')</a>
            </li>

            <li class="active">
                <strong>@lang('pos.tables')</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div style="text-align: center; margin-top: 8px; font-size: 18px">
                        {{ $table->table_name }}

                        <img loading="lazy" style="margin: auto" width="400" alt=""
                            src="{{asset('uploads/qr/table-' . $table->id . '.png')}}" class="img-responsive">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
