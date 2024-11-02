@extends('formbuilder::layouts.master')

@section('page_title', $form->name)

@section('content')
    <div class="col-sm-12 list-container">
        <div class="card">
            <div class="card-body p-0">
                <div class="card-body">
                    <h3 class="text-center text-success">
                        {{ __('Your entry for " :x " was successfully submitted.', ['x' => $form->name]) }}
                    </h3>
                    <p class="text-center"><a class="text-success"
                            href="{{ route('site.index') }}"><u>{{ __('Return Home') }}</u></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
