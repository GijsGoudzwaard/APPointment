@extends('layouts.layout', ['page' => 'Create company'])

@section('content')

	<h1>Create company</h1>

	{{ Form::open(['url' => action('CompanyController@store'), 'method' => 'post', 'files' => true]) }}

		<ul class="nav nav-tabs" id="guide-tabs">
			<li class="active">
				<a href="#info" data-toggle="tab">{{ trans('forms.info') }}</a>
			</li>
			<li>
				<a href="#opening-hours" data-toggle="tab">{{ trans('forms.opening_hours') }}</a>
			</li>
		</ul>

		<div class="tab-content">
			<div id="info" class="tab-pane active">
				<div class="form-group">
					<label for="name">{{ trans('forms.name') }}</label>
					<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="{{ trans('forms.name') }}" autofocus required />
				</div>

				<div class="form-group">
					<label for="subdomain">{{ trans('forms.subdomain') }}</label>
					<input type="text" class="form-control" id="subdomain" name="subdomain" value="{{ old('subdomain') }}" placeholder="{{ trans('forms.subdomain') }}" required />
				</div>

				<div class="form-group">
					<label for="email">{{ trans('forms.email') }}</label>
					<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="{{ trans('forms.email') }}" required />
				</div>

				<div class="form-group">
					<label for="address">{{ trans('forms.address') }}</label>
					<input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="{{ trans('forms.address') }}" required />
				</div>

				<div class="form-group">
					<label for="phonenumber">{{ trans('forms.phonenumber') }}</label>
					<input type="text" class="form-control" id="phonenumber" name="phonenumber" value="{{ old('phonenumber') }}" placeholder="{{ trans('forms.phonenumber') }}" required />
				</div>

				<div class="form-group">
					<label for="logo">{{ trans('forms.logo') }}</label>
					<input type="file" class="form-control" id="logo" name="logo">
				</div>
			</div>

			<div id="opening-hours" class="tab-pane">
				<div class="form-group">
					<div class="form-inline datetimepicker">
						@foreach($days as $key => $day)
							<div class="{{ $key }}">
								<label for="from[{{ $key }}]">
									{{ trans('days.' . $key) }}
								</label>
								<input type="checkbox" name="enabled[{{ $key }}]" checked />
								<div class="input-group date from form-group">
					                <input type="text" class="form-control picker" id="from[{{ $key }}]" value="{{ old('from[' . $key . ']') }}" name="from[{{ $key }}]" />
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
								<label for="to[{{ $key }}]">{{ trans('forms.to') }}</label>
								<div class="input-group date to form-group">
					                <input type="text" class="form-control picker" id="to[{{ $key }}]" value="{{ old('to[' . $key . ']') }}" name="to[{{ $key }}]" />
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
							</div>
						@endforeach
					</div>
				</div>
			</div>

		</div>
		<button type="submit" class="btn btn-default">{{ trans('forms.submit') }}</button>

	{{ Form::close() }}

@stop
