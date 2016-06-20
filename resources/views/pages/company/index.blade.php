@extends('layouts.layout', ['page' => 'Appointment types'])

@section('content')

	<a href="{{ route('companies.create') }}" class="btn btn-default create">Create company</a>
	<div class="table-responsive">
		<table class="table-responsive table table-hover">
			<h1>Companies</h1>
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Phonenumber</th>
					<th>Accounts</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($companies as $company)
					<tr>
						<td>{{ $company->name }}</td>
						<td>{{ $company->email }}</td>
						<td>{{ $company->phonenumber }}</td>
						<td><a href="{{ route('companies.{company_id}.users.index', $company->id) }}" class="btn btn-default">Accounts</a></td>
						<td>
							<a href="{{ route('companies.edit', $company->id) }}"><i class="material-icons">edit</i></a>
							<a href="javascript:;" data-toggle="modal" class="open-modal" data-target="#delete-modal" data-title="{{ $company->name }}" data-url="{{ route('companies.destroy', $company->id) }}"><i class="material-icons">delete</i></a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	@include('layouts.delete-modal')

@stop
