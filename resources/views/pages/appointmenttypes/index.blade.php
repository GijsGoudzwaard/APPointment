@extends('layouts.layout', ['page' => 'Appointment types'])

@section('content')

	<a href="{{ url('appointmenttypes/create') }}" class="btn btn-default create">Create appointment type</a>
	<div class="table-responsive">
		<table class="table-responsive table table-hover">
			<h1>Appointment types</h1>
			<thead>
				<tr>
					<th>Name</th>
					<th>Time (minutes)</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($appointment_types as $appointment_type)
					<tr>
						<td>{{ $appointment_type->name }}</td>
						<td>{{ $appointment_type->time }}</td>
						<td>
							<a href="{{ url('/appointmenttypes/' . $appointment_type->id . '/edit') }}"><i class="material-icons">edit</i></a>
							<a href="javascript:;" data-toggle="modal" class="open-modal" data-target="#delete-modal" data-title="{{ $appointment_type->name }}" data-url="{{ url('appointmenttypes/' . $appointment_type->id . '/delete') }}"><i class="material-icons">delete</i></a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="delete-modal modal fade" id="delete-modal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Delete</h4>
				</div>
				<div class="modal-body">
					<p>
						Are you sure you want to delete <strong class="text"></strong>?
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<a href class="btn link btn-primary submit">Submit</a>
				</div>
			</div>
		</div>
	</div>

@stop
