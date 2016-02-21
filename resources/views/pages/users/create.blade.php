@extends('layouts.layout', ['page' => 'New account'])

@section('content')

	<h1>Create a new account</h1>

	{{ Form::open(['url' => action('Auth\UserController@store'), 'method' => 'post']) }}

		<div class="form-group">
			<label for="name">Name *</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Name" autofocus required>
		</div>

		<div class="form-group">
			<label for="email">Email *</label>
			<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
		</div>

		<div class="form-group">
			<label for="password">Password *</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Password">
		</div>

		<button type="submit" class="btn btn-default">Submit</button>

	{{ Form::close() }}

@stop
