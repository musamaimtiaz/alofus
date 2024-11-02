{{-- This is a secondary layer between pages and the master layout to inject styles and scripts easily --}}

{{-- Extending master layout --}}
@extends('site.layouts.user_panel.master')

{{-- All the contents will be placed here --}}
@section('parent-content')
    @yield('content')
    @if (isActive('Ticket') && preference('chat'))
        @include('ticket::message')
    @endif
@endsection

{{-- All the styles will be injected here --}}
@section('parent-css')
    @yield('css')
    @stack('styles')
@endsection

{{-- All the scripts will be injected here --}}
@section('parent-js')
    @yield('js')
    @stack('scripts')
@endsection
