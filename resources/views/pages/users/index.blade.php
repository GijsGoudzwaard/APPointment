@extends('layouts.layout', ['page' => trans('base.accounts')])
@section('content')

	<a href="{{ route($company_id ? 'companies.{company_id}.users.create' : 'users.create', $company_id) }}" class="btn btn-default create">{{ trans('forms.create_a_new') }} {{ trans('forms.account') }}</a>
	<div class="table-responsive">
		<table class="table-responsive table table-hover">
			<h1>{{ trans('base.accounts') }}</h1>

			<thead>
				<tr>
					<th>{{ trans('forms.avatar') }}</th>
					<th>{{ trans('forms.name') }}</th>
					<th>{{ trans('forms.email') }}</th>
					{!! ($company_id) ? '<th>' . trans('forms.login') . '</th>' : '' !!}
					<th>{{ trans('forms.active') }}</th>
					<th>{{ trans('forms.company') }}</th>
					<th>{{ trans('forms.actions') }}</th>
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
						{!! ($company_id) ? '<td><a href="' . action('Auth\UserController@loginUsingId', [$company_id, $user->id]) . '" class="btn btn-default">' . trans('forms.login') . '</a></td>' : '' !!}
						<td>{{ $user->active == 1 ? trans('base.yes') : trans('base.no') }}</td>
						<td>{{ $company->name }}</td>
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
