@extends('layouts.layout', ['page' => trans('forms.appointment_types')])

@section('content')

	<a href="{{ route('appointmenttypes.create') }}" class="btn btn-default create">{{ trans('forms.create') }} {{ strtolower(trans('forms.appointment_type')) }}</a>
	<div class="table-responsive">
		<table class="table-responsive table table-hover">
			<h1>{{ trans('forms.appointment_types') }}</h1>
			<thead>
				<tr>
					<th>{{ trans('forms.name') }}</th>
					<th>{{ trans('forms.time') }} ({{ trans('forms.minutes') }})</th>
					<th>{{ trans('forms.actions') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($appointment_types as $appointment_type)
					<tr>
						<td>{{ $appointment_type->name }}</td>
						<td>{{ $appointment_type->time }}</td>
						<td>
							<a href="{{ route('appointmenttypes.edit', $appointment_type->id) }}"><i class="material-icons">edit</i></a>
							<a href="javascript:;" data-toggle="modal" class="open-modal" data-target="#delete-modal" data-title="{{ $appointment_type->name }}" data-url="{{ route('appointmenttypes.destroy', $appointment_type->id) }}"><i class="material-icons">delete</i></a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	@include('layouts.delete-modal')

@stop
