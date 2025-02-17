@extends('layouts.app')

@section('content')
@include("backend.category/cropper")

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>@lang('common.add') @lang('common.category')</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('')}}">>@lang('common.home')<</a> </li> <li>
                        <a href="{{url('categories')}}">@lang('common.categories')</a>
            </li>
            <li class="active">
                <strong>@lang('common.add_new')</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Add Category</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>


                    </div>
                </div>
                <div class="ibox-content">
                    <form action="{{ url('categories') }}" class="form-horizontal" method="POST"
                        enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="form-group"><label class="col-sm-2 control-label">@lang('common.name')</label>
                            <div class="col-sm-10"><input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">

                                <a class="btn btn-white" href="{{ url('categories') }}">@lang('common.cancel')</a>
                                <button class="btn btn-primary ml-2" type="submit">@lang('common.save')</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <form id="uploadimage" class="text-center" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="cropped_value" id="cropped_value" value="">

                <label title="Upload image file" for="inputImage" class="">

                    <div class="upload-pic img-circle" style="">
                        <img loading="lazy" id="image_source" class="img-circle" src="" alt="">

                    </div>
                    <div class="upload-pic-new btn btn-primary text-center">
                        <input type="file" name="file" id="cropper" style="display:none" />
                        <label class="mb-0" for="cropper">
                            <div class="pic-placeholder">

                                <span class="upload_button"> <i class="fa fa-picture-o"></i>
                                    Upload Photo </span>
                            </div>
                        </label>
                    </div>

            </form>
        </div>


    </div>
</div>

<style>
    .cropper-container.cropper-bg {
        background: #fff !important;
        background-image: none !important;
    }

    .cropper-modal {
        opacity: .5;
        background-color: #fff;
    }

    .upload-pic {
        height: 200px;
        width: 200px;
        background: #ccc;
        margin: 10px;
    }

    .upload_button {
        margin-top: 10px;
    }
</style>


@endsection