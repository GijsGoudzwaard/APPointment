@extends('layouts.layout', ['page' => $user->name])

@section('content')

	<h1>{{ trans('forms.modify') }} '{{ $user->name }}'</h1>

	{{ Form::open(['url' => action('SettingController@update', $user), 'method' => 'put']) }}

		<div class="form-group">
			<label for="name">{{ trans('forms.name') }} *</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" placeholder="{{ trans('forms.name') }}" autofocus required>
		</div>

		<div class="form-group">
			<label for="email">{{ trans('forms.email') }} *</label>
			<input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="{{ trans('forms.email') }}" required>
		</div>

		<div class="form-group">
			<label for="password">{{ trans('forms.password') }}</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="{{ trans('forms.password') }}">
		</div>

		<button type="submit" class="btn btn-default">Submit</button>

	{{ Form::close() }}

@stop
