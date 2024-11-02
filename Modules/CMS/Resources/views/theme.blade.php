@extends('admin.layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('Modules/CMS/Resources/assets/css/style.min.css') }}">
@endsection
@section('content')
<div class="col-sm-12">
    <div class="row">
        <div class="card card-info display_block" id="nav">
            <div class="col-md-3 col-sm-12 " aria-labelledby="navbarDropdown">
                <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <nav id="column_left">
                        <div class="card-header p-t-20">
                            <h5><a href="#" id="general-settings">{{ __('Manage') . " " . __('Themes') }}</a></h5>
                        </div>
                        <ul class="nav nav-list flex-column">
                            <li>
                                <a class="accordion-heading" data-toggle="collapse" data-target="#submenu0">{{ __("General") }} <span class="pull-right"><b class="caret"></b></span></a>
                            </li>

                            <li>
                                <a class="accordion-heading" data-toggle="collapse" data-target="#submenu1">{{ __("Header") }} <span class="pull-right"><b class="caret"></b></span></a>
                                <ul class="nav nav-list flex-column flex-nowrap collapse ml-2" id="submenu1">
                                    <li><a id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">{{ __("Header One") }}</a></li>
                                    <li><a id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">{{ __("Header Two") }}</a></li>
                                </ul>
                            </li>

                            <li>
                                <a class="accordion-heading" data-toggle="collapse" data-target="#submenu2">{{ __("Footer") }} <span class="pull-right"><b class="caret"></b></span></a>
                                <ul class="nav nav-list flex-column flex-nowrap collapse ml-2" id="submenu2">
                                    <li><a id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">{{ __("Footer One") }}</a></li>
                                    <li><a id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">{{ __("Footer Two") }}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </ul>
            </div>
        </div>
        <div class="col-md-9 col-sm-12">
            <div class="card-header p-t-20">
                <h5> <h5><a href="#">{{ __('Themes') }} </a> >> {{ __('General') }}</h5></h5>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <p class="mb-0">
                        {{ __("One") }}
                    </p>
                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <p class="mb-0">{{ __("Two") }}</p>
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <p class="mb-0">{{ __("Three") }}.</p>
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    <p class="mb-0">{{ __("Four") }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
