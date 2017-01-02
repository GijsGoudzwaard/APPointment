@extends('layouts.layout', ['page' => trans('base.customers')])
@section('content')

	<div class="table-responsive">
		<table class="table-responsive table table-hover">
			<h1>{{ trans('base.customers') }}</h1>

			<thead>
				<tr>
					<th>{{ trans('forms.name') }}</th>
					<th>{{ trans('forms.email') }}</th>
					<th>{{ trans('forms.phonenumber') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr>
						<td>{{ $user->firstname . ' ' . $user->surname }}</td>
						<td>{{ $user->email }}</td>
						<td>{{ $user->phonenumber }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

@stop
