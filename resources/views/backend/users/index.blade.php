@extends('layouts.app')

@section('content')

<link href="assets/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

<style>
    .bussinesss:not(:last-child)::after {
        content: ', ';
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>@lang('common.users')</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('')}}">@lang('common.home')</a>
            </li>

            <li class="active">
                <strong>@lang('common.users')</strong>
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
                    <h5>@lang('common.users') </h5>
                    <div class="ibox-tools">

                        @if($busRole == 'Admin')
                            <a href="{{ url('users/create') }}" class="btn btn-primary btn-xs">@lang('common.add_new')</a>
                        @endif

                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('common.name')</th>
                                    <th>@lang('common.email')</th>
                                    <th>@lang('common.role')</th>
                                    <th>@lang('common.bussiness')</th>
                                    <th>@lang('common.bussinessRole')</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role->display_name }}</td>
                                    <td>
                                        @foreach($user->bussiness as $bus)
                                            <b class="bussinesss">{{ $bus->name ?? '' }}</b>
                                        @endforeach
                                    </td>
                                    <td>{{ $user->bussiness_role }}</td>

                                    <td class="tb-btn">
                                        @if($busRole == 'Admin')
                                        <form id="delete-user" action="{{ url('users/' . $user->id) }}" method="POST"
                                            class="form-inline">
                                            <input type="hidden" name="_method" value="delete">
                                            {{ csrf_field() }}
                                            <input type="submit" value="@lang('common.delete')"
                                                class="btn btn-danger btn-xs ml-2 pull-right btn-delete">
                                        </form>
                                        <a href="{{ url('users/' . $user->id . '/edit') }}"
                                            class="btn btn-primary btn-xs pull-right">@lang('common.edit')</a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                @include('partials.table-blank-slate', ['colspan' => 3])
                                @endforelse
                            </tbody>


                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


<script src="assets/js/plugins/dataTables/datatables.min.js"></script>


<script>
    $(document).ready(function(){
            $('.dataTables-example').DataTable({
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

            


        });

        
</script>


@endsection