@extends('layouts.app')

@section('content')

<dl>
    @foreach ($booking->getAttributes() as $name => $value)
    <dt> {{ $name }}</dt>
    <dd> {{ $booking->$name }}</dd>
    @endforeach
</dl>

@foreach($booking->users as $user)

<p> {{ $user->name }} </p>

@endforeach

@endsection