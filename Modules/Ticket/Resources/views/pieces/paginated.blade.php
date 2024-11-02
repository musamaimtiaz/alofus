@php
$messages = $messages->reverse();
@endphp
@foreach ($messages as $message)
    @include('ticket::pieces.single-message')
@endforeach
