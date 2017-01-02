@extends('layouts.layout', ['page' => $user->name])

@section('content')

	<h1>{{ trans('forms.modify') }} '{{ $user->firstname . ' ' . $user->surname }}'</h1>

	{{ Form::open(['url' => action('Auth\UserController@update', $user), 'method' => 'put', 'files' => true]) }}

		<div class="form-group">
			<label for="firstname">{{ trans('forms.firstname') }} *</label>
			<input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname') ?: $user->firstname }}" placeholder="{{ trans('forms.firstname') }}" autofocus required>
		</div>

		<div class="form-group">
			<label for="surname">{{ trans('forms.surname') }} *</label>
			<input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') ?: $user->surname }}" placeholder="{{ trans('forms.surname') }}" required>
		</div>

		<div class="form-group">
			<label for="email">{{ trans('forms.email') }} *</label>
			<input type="email" class="form-control" id="email" name="email" value="{{ old('email') ?: $user->email }}" placeholder="{{ trans('forms.email') }}" required>
		</div>

		<div class="form-group">
			<label for="phonenumber">{{ trans('forms.phonenumber') }} *</label>
			<input type="text" class="form-control" id="phonenumber" name="phonenumber" value="{{ old('phonenumber') ?: $user->phonenumber }}" placeholder="{{ trans('forms.phonenumber') }}" required>
		</div>

		<div class="form-group">
			<label for="password">{{ trans('forms.password') }}</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="{{ trans('forms.password') }}">
		</div>

		<div class="form-group">
			<label for="active">{{ trans('forms.active') }}</label>
			{{ Form::select('active', [1 => trans('base.yes'), 0 => trans('base.no')], $user->active, [
				'class' => 'form-control',
				'id' => 'active'
			]) }}
		</div>

		<div class="form-group">
			<label for="avatar">{{ trans('forms.avatar') }}</label>
			<input type="file" class="form-control" id="avatar" name="avatar">
		</div>

		@if (isset($user->avatar) && $user->avatar != '')
			<div class="form-group">
				<img src="{{ url($user->avatar) }}" alt="{{ $user->name }}">
			</div>
		@endif

		<button type="submit" class="btn btn-primary">{{ trans('forms.submit') }}</button>
		<a href="{{ route($user->company_id == get_company()->id ? 'users.index' : 'companies.users.index', $user->company_id) }}" class="btn btn-default">{{ trans('forms.back') }}</a>

	{{ Form::close() }}

@stop
