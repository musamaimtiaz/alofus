@extends('admin.layouts.app')
@section('page_title', __('Media-Manager'))
@section('css')
  <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/fileupload/css/fileupload.min.css') }}">
@endsection
@section('content')
<div class="col-sm-12">
    <div class="card card-height">
        <div class="card-header">
            <h5><a href="{{ route('mediaManager.uploadedFiles') }}">{{ __('File Upload') }}</a></h5>
            <div class="form-group row">
                <label class="col-md-8 control-label"></label>
                <div class="col-md-8">
                  <span class="badge badge-danger">{{ __('Note') }}!</span> {{ __('Allowed File Extensions:') . $Files }}
                </div>
            </div>
            <div class="card-header-right d-inline-block ltr:me-1 rtl:ms-1" >
                <a href="{{ route('mediaManager.uploadedFiles') }}" class="btn btn-outline-primary custom-btn-small">
                <span> &nbsp;</span>{{ __('File List') }}
                </a>
            </div>
        </div>
        <div class="card-block file-upload-card-block">
            <form action="{{ route("mediaManager.store") }}" class="dropzone h-100 create-image-form">
                @csrf
                <div class="fallback">
                    <input name="file" type="file" multiple />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')

<script src="{{ asset('public/datta-able/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
    'use strict';
    var maxFileSize = "{{ preference('file_size') }}";
    var acceptedFiles = "{{ $acceptedFiles }}";
  </script>
<script src="{{ asset('public/dist/plugins/dropzone/dropzone.min.js') }}"></script>
@endsection
