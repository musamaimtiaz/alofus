@extends('errors.minimal-layout')
@section('title', '403 nauthorized action.')
@section('code', '403')

@section('name', 'Unauthorized action.')

@section('message')
    {!! $message!!}
@endsection
