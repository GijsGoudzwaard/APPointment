@extends('layouts.layout', ['page' => 'Accounts'])
@section('content')

	<a href="{{ url('users/create') }}" class="btn btn-default create">Create new account</a>
	<div class="table-responsive">
		<table class="table-responsive table table-hover">
			<h1>Accounts</h1>
			<thead>
				<tr>
					<th>Avatar</th>
					<th>Name</th>
					<th>Email</th>
					{!! ($company_id) ? '<th>Login</th>' : '' !!}
					<th>Company</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr>
						<td>
							<div class="avatar" style="background-image: url({{ url($user->avatar ?: 'assets/img/default_avatar.png') }})"></div>
						</td>
						<td>{{ $user->firstname . ' ' . $user->surname }}</td>
						<td>{{ $user->email }}</td>
						{!! ($company_id) ? '<td><a href="' . action('Auth\UserController@loginUsingId', [$company_id, $user->id]) . '" class="btn btn-default">Login</a></td>' : '' !!}
						<td>{{ $user->company->name }}</td>
						<td>
							<a href="{{ url('/users/' . $user->id . '/edit') }}"><i class="material-icons">edit</i></a>
							<a href="javascript:;" data-toggle="modal" class="open-modal" data-target="#delete-modal" data-title="{{ $user->firstname . ' ' . $user->surname }}" data-url="{{ url('users/' . $user->id . '/delete') }}"><i class="material-icons">delete</i></a>
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
