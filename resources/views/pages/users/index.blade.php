@extends('layouts.layout', ['page' => 'Accounts'])
@section('content')

	<a href="{{ url('users/create') }}" class="btn btn-default create">Create new account</a>
	<div class="table-responsive">
		<table class="table-responsive table table-hover">
			<h1>Accounts</h1>
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					{!! ($environment_id) ? '<th>Login</th>' : '' !!}
					<th>Company</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						{!! ($environment_id) ? '<td><a href="' . action('Auth\UserController@loginUsingId', [$environment_id, $user->id]) . '" class="btn btn-default">Login</a></td>' : '' !!}
						<td>{{ $user->environment->company->name }}</td>
						<td>
							<a href="{{ url('/users/' . $user->id . '/edit') }}"><i class="material-icons">edit</i></a>
							<a href="{{ url('/users/' . $user->id . '/delete') }}"><i class="material-icons">delete</i></a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

@stop
