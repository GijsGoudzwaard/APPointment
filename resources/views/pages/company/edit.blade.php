@extends('layouts.layout', ['page' => $company->name])

@section('content')

	<h1>{{ trans('forms.modify') }} '{{ $company->name }}'</h1>

	{{ Form::open(['url' => route('company.update', $company->id), 'method' => 'put', 'files' => true]) }}

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
					<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?? $company->name }}" placeholder="{{ trans('forms.name') }}" autofocus>
				</div>

				@if (isset($allowed) && $allowed)
					<div class="form-group">
						<label for="subdomain">{{ trans('forms.subdomain') }}</label>
						<input type="text" class="form-control" id="subdomain" name="subdomain" value="{{ old('subdomain') ?? $company->subdomain }}" placeholder="{{ trans('forms.subdomain') }}" required />
					</div>
				@endif

				<div class="form-group">
					<label for="email">{{ trans('forms.email') }}</label>
					<input type="email" class="form-control" id="email" name="email" value="{{ old('email') ?? $company->email }}" placeholder="{{ trans('forms.email') }}">
				</div>

				<div class="form-group">
					<label for="address">{{ trans('forms.address') }}</label>
					<input type="text" class="form-control" id="address" name="address" value="{{ old('address') ?? $company->address }}" placeholder="{{ trans('forms.address') }}">
				</div>

				<div class="form-group">
					<label for="phonenumber">{{ trans('phonenumber') }}</label>
					<input type="text" class="form-control" id="phonenumber" name="phonenumber" value="{{ old('phonenumber') ?? $company->phonenumber }}" placeholder="{{ trans('phonenumber') }}">
				</div>

				<div class="form-group">
					<label for="logo">{{ trans('forms.logo') }}</label>
					<input type="file" class="form-control" id="logo" name="logo">
				</div>

				@if (isset($company->logo) && !empty($company->logo))
					<img src="{{ url($company->logo) }}" alt="{{ $company->name }}" class="logo">
				@endif
			</div>

			<div id="opening-hours" class="tab-pane">
				<div class="form-group">
					<div class="form-inline datetimepicker">
						@foreach($company->days as $key => $day)
							<div class="{{ $key }}">
								<label for="from[{{ $key }}]">
									{{ trans('days.' . $key) }}
								</label>
								<input type="checkbox" name="enabled[{{ $key }}]" {{ (isset($company->openingHours()->$key)) ? 'checked' : '' }} />
								<div class="input-group date from form-group">
					                <input type="text" class="form-control picker" id="from[{{ $key }}]" value="{{ $company->openingHours()->$key->from ?? '' }}" name="from[{{ $key }}]" {{ (!isset($company->openingHours()->$key)) ? 'disabled' : '' }} />
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
								<label for="to[{{ $key }}]">{{ trans('forms.to') }}</label>
								<div class="input-group date to form-group">
					                <input type="text" class="form-control picker" id="to[{{ $key }}]" value="{{ $company->openingHours()->$key->to ?? '' }}" name="to[{{ $key }}]" {{ (!isset($company->openingHours()->$key)) ? 'disabled' : '' }} />
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
		<button type="submit" class="btn btn-primary">{{ trans('forms.submit') }}</button>

	{{ Form::close() }}

@stop
