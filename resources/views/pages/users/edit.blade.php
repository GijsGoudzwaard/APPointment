@extends('layouts.layout', ['page' => $user->name])

@section('content')

	<h1>Modify user '{{ $user->firstname . ' ' . $user->surname }}'</h1>

	{{ Form::open(['url' => action('Auth\UserController@update', $user), 'method' => 'put', 'files' => true]) }}

		<div class="form-group">
			<label for="firstname">Firstname *</label>
			<input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname') ?: $user->firstname }}" placeholder="Firstname" autofocus required>
		</div>

		<div class="form-group">
			<label for="surname">Surname *</label>
			<input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') ?: $user->surname }}" placeholder="Firstname" required>
		</div>

		<div class="form-group">
			<label for="email">Email *</label>
			<input type="email" class="form-control" id="email" name="email" value="{{ old('email') ?: $user->email }}" placeholder="Email" required>
		</div>

		<div class="form-group">
			<label for="phonenumber">Phonenumber *</label>
			<input type="text" class="form-control" id="phonenumber" name="phonenumber" value="{{ old('phonenumber') ?: $user->phonenumber }}" placeholder="Phonenumber" required>
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Password">
		</div>

		<div class="form-group">
			<label for="active">Active</label>
			{{ Form::select('active', ['Yes', 'No'], $user->active, [
				'class' => 'form-control',
				'id' => 'active'
			]) }}
		</div>

		<div class="form-group">
			<label for="avatar">Avatar</label>
			<input type="file" class="form-control" id="avatar" name="avatar">
		</div>

		@if (isset($user->avatar) && $user->avatar != '')
			<div class="form-group">
				<img src="{{ url($user->avatar) }}" alt="{{ $user->name }}">
			</div>
		@endif

		<button type="submit" class="btn btn-default">Submit</button>
		<a href="{{ url('users') }}" class="btn btn-default">Back</a>

	{{ Form::close() }}

@stop
