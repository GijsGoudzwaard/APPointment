@extends('layouts.layout', ['page' => trans('base.companies')])

@section('content')

	<a href="{{ route('companies.create') }}" class="btn btn-default create">{{ trans('forms.create_a_new') }} {{ trans('forms.company') }}</a>
	<div class="table-responsive">
		<table class="table-responsive table table-hover">
			<h1>{{ trans('base.companies') }}</h1>
			<thead>
				<tr>
					<th>{{ trans('forms.name') }}</th>
					<th>{{ trans('forms.email') }}</th>
					<th>{{ trans('forms.phonenumber') }}</th>
					<th>{{ trans('base.accounts') }}</th>
					<th>{{ trans('forms.actions') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($companies as $company)
					<tr>
						<td>{{ $company->name }}</td>
						<td>{{ $company->email }}</td>
						<td>{{ $company->phonenumber }}</td>
						<td><a href="{{ route('companies.{company_id}.users.index', $company->id) }}" class="btn btn-default">{{ trans('base.accounts') }}</a></td>
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
