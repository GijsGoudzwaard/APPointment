@extends('layouts.layout', ['page' => 'Customers'])
@section('content')

	<div class="table-responsive">
		<table class="table-responsive table table-hover">
			<h1>Customers</h1>
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Phonenumber</th>
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
