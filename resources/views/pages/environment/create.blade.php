@extends('layouts.layout', ['page' => 'Create new environment'])

@section('content')

	<h1>Create new environment</h1>

	{{ Form::open(['url' => action('EnvironmentController@store'), 'method' => 'post']) }}

		<div class="form-group">
			<label for="name">Naam *</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Naam" autofocus required>
		</div>
		<div class="form-group">
			<label for="subdomain">Subdomein *</label>
			<input type="text" class="form-control" id="subdomain" name="subdomain" value="{{ old('subdomain') }}" placeholder="Subdomein" required>
		</div>

		<button type="submit" class="btn btn-default">Submit</button>
		<a href="{{ url('environments') }}" class="btn btn-default">Back</a>

	{{ Form::close() }}

@stop
