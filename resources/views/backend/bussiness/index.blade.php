@extends('layouts.app')

@section('content')

<link href="assets/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>@lang('common.bussiness') </h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('')}}">@lang('common.home')</a>
            </li>

            <li class="active">
                <strong>@lang('common.bussiness')</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>@lang('common.bussiness') </h5>
                    <div class="ibox-tools">
                        <a href="{{ url('bussiness/create') }}"
                            class="btn btn-primary btn-xs">@lang('common.add_new')</a>

                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('common.name')</th>
                                    <th>@lang('common.description')</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bussiness as $key => $bus)
                                <tr class="gradeX">
                                    <td>{{ $bussiness->firstItem() + $key }}</td>
                                    <td>{{ $bus->name }}</td>
                                    <td>{{ $bus->description }}</td>

                                    <td class="tb-btn">
                                        <form id="delete-customer" action="{{ url('bussiness/' . $bus->id) }}"
                                            method="POST" class="form-inline">
                                            <input type="hidden" name="_method" value="delete">
                                            {{ csrf_field() }}
                                            <input type="submit" value="Delete"
                                                class="btn btn-danger ml-2 btn-xs pull-right btn-delete">
                                        </form>
                                        <a href="{{ url('bussiness/' . $bus->id . '/edit') }}"
                                            class="btn btn-primary btn-xs pull-right">Edit</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">@lang('common.no_record_found') </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="5">
                                        {!! $bussiness->render() !!}
                                    </td>
                                </tr>
                            </tbody>


                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>




@endsection