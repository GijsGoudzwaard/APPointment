@extends('layouts.layout', ['page' => $company->name ?? get_environment()->name])

@section('content')

	<h1>Modify company '{{ $company->name ?? get_environment()->name }}'</h1>

	@if (!empty($company))
		{{ Form::open(['url' => action('CompanyController@update', $company->id), 'method' => 'put', 'files' => true]) }}
	@else
		{{ Form::open(['url' => action('CompanyController@store'), 'method' => 'post', 'files' => true]) }}
	@endif

		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ $company->name ?? get_environment()->name }}" placeholder="Name" autofocus>
		</div>

		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" id="email" name="email" value="{{ $company->email ?? '' }}" placeholder="Email">
		</div>

		<div class="form-group">
			<label for="address">Address</label>
			<input type="text" class="form-control" id="address" name="address" value="{{ $company->address ?? '' }}" placeholder="Address">
		</div>

		<div class="form-group">
			<label for="phonenumber">Phonenumber</label>
			<input type="text" class="form-control" id="phonenumber" name="phonenumber" value="{{ $company->phonenumber ?? '' }}" placeholder="Phonenumber">
		</div>

		<div class="form-group">
			<label for="logo">Logo</label>
			<input type="file" class="form-control" id="logo" name="logo">
		</div>

		@if (isset($company->logo))
			<img src="{{ url($company->logo) }}" alt="{{ $company->name }}" class="logo">
		@endif

		<button type="submit" class="btn btn-default">Submit</button>

	{{ Form::close() }}

@stop
