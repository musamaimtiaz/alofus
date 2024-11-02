@extends('admin.layouts.app')
@section('page_title', __('Users Import'))
@section('content')
<!-- Main content -->
<div class="col-sm-12" id="user-import-container">
    <div class="card Recent-Users">
        <div class="card-header">
            <h5>{{ __('Users Import') }}</h5>
        </div>
        <div class="card-body p-0">
            <div class="col-sm-12">
                <div class="card-block pt-2">
                    <button class="btn btn-outline-primary custom-btn-smal d-inline-flex rtl:gap-2 align-items-center" id="fileRequest"><i
                            class="fa fa-download"></i>{{ __('Download Sample') }}</button>
                    <hr>
                    <p>{{ __('Your CSV data should be in the format below. The first line of your CSV file should be the column headers as in the table example. If an user does not have any role, customer role would be added by default. Also make sure that your file is UTF-8 to avoid unnecessary encoding problems.') }}
                    </p>
                    <span class="badge badge-info mb-10">{{ __('Note') }}</span> <small
                        class="text-info">&nbsp;{{ __('Duplicate email rows and team members with unmatched roles would not be imported.') }}
                    </small>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}<span class="text-danger">*</span></th>
                                    <th>{{ __('Email') }}<span class="text-danger">*</span></th>
                                    <th>{{ __('Role') }}</th>
                                    <th>{{ __('Password') }}<span class="text-danger">*</span></th>
                                    <th>{{ __('Status') }}<span class="text-danger">*</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Michel Anam</td>
                                    <td>anam@test.com</td>
                                    <td>admin</td>
                                    <td>M@x87e7eex3</td>
                                    <td>Active</td>
                                </tr>
                                <tr>
                                    <td>Nill Armstrong</td>
                                    <td>armstrong@test.com</td>
                                    <td>customer</td>
                                    <td>HT#h74xxTBkk</td>
                                    <td>Pending</td>
                                </tr>
                                <tr>
                                    <td>Lenin Rock</td>
                                    <td>lenin@test.com</td>
                                    <td>customer</td>
                                    <td>JY&haa4rTBkk</td>
                                    <td>Inactive</td>
                                </tr>
                            </tbody>
                        </table>
                        <span class="badge badge-info">{{ __('Note') }}</span> <small
                            class="text-info">{{ __('Required field is mandatory') }}</small>
                    </div><br>

                    <form action="{{ route('epz.import.users') }}" method="post" id="myform1" class="form-horizontal"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label pt-1">{{ __('Choose CSV File') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="custom-file position-relative col-md-8">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file"
                                            id="validatedCustomFile">
                                        <label class="custom-file-label overflow_hidden d-flex align-items-center"
                                            for="validatedCustomFile">{{ __('Upload csv...') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 control-label note"></label>
                            <div class="col-md-8" id='note_txt_1'>
                                <span class="badge badge-info">{{ __('Note') }}</span> <small
                                    class="text-info">{{ __('Allowed File Extensions: csv') }}</small>
                            </div>
                            <div class="col-md-8" id='note_txt_2'>
                            </div>
                        </div>

                        <!-- /.box-body -->
                        <div class="col-sm-8 px-0 mt-3">
                            <a href="{{ route('users.index') }}" class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                            <button class="btn custom-btn-submit" type="submit"
                                id="submit">{{ __('Import') }}</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('public/dist/js/custom/user.min.js') }}"></script>
@endsection
