@extends('layouts.layout', ['page' => $user->name])

@section('content')

	<h1>Modify user '{{ $user->name }}'</h1>

	{{ Form::open(['url' => action('Auth\UserController@update', $user), 'method' => 'put']) }}

		<div class="form-group">
			<label for="name">Name *</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" placeholder="Name" autofocus required>
		</div>

		<div class="form-group">
			<label for="email">Email *</label>
			<input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="Email" required>
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
		</div>

		<button type="submit" class="btn btn-default">Submit</button>

	{{ Form::close() }}

@stop
