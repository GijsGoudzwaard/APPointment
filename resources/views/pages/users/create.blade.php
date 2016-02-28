@extends('layouts.layout', ['page' => 'New account'])

@section('content')

	<h1>Create a new account</h1>

	{{ Form::open(['url' => action('Auth\UserController@store'), 'method' => 'post', 'files' => true]) }}

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

		<div class="form-group">
			<label for="avatar">Avatar</label>
			<input type="file" class="form-control" id="avatar" name="avatar">
		</div>

		@if (isset($user->avatar) && $user->avatar != '')
			<div class="form-group">
				<img src="{{ url($user->avatar) }}" alt="{{ $user->name }}" class="avatar">
			</div>
		@endif

		<button type="submit" class="btn btn-default">Submit</button>
		<a href="{{ url('users') }}" class="btn btn-default">Back</a>

	{{ Form::close() }}

@stop
