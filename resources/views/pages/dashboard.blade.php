@extends('layouts.layout', ['page' => null])

@section('content')

	<h1>Hallo {{ Auth::user()->name }}!</h1>

@endsection
