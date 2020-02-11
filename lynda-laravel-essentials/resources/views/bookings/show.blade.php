@extends('layouts.app')

@section('content')

<dl>
    @foreach ($booking->getAttributes() as $name => $value)
    <dt> {{ $name }}</dt>
    <dd> {{ $booking->$name }}</dd>
    @endforeach
</dl>

@endsection