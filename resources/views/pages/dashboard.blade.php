@extends('layouts.layout', ['page' => null])

@section('content')

	<h1>Hallo {{ Auth::user()->firstname }}!</h1>

@endsection
