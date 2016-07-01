@extends('layouts.layout', ['page' => 'Accounts'])
@section('content')

	<a href="{{ route($company_id ? 'companies.{company_id}.users.create' : 'users.create', $company_id) }}" class="btn btn-default create">Create new account</a>
	<div class="table-responsive">
		<table class="table-responsive table table-hover">
			<h1>Accounts</h1>
			<thead>
				<tr>
					<th>Avatar</th>
					<th>Name</th>
					<th>Email</th>
					{!! ($company_id) ? '<th>Login</th>' : '' !!}
					<th>Active</th>
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
						<td>{{ $user->active == 1 ? 'Yes' : 'No' }}</td>
						<td>{{ $user->company->name }}</td>
						<td>
							<a href="{{ route('users.edit', $user->id) }}"><i class="material-icons">edit</i></a>
							<a href="javascript:;" data-toggle="modal" class="open-modal" data-target="#delete-modal" data-title="{{ $user->firstname . ' ' . $user->surname }}" data-url="{{ route('users.destroy', $user->id) }}"><i class="material-icons">delete</i></a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	@include('layouts.delete-modal')

@stop
