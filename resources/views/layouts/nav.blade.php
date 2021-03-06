<nav class="navbar navbar-fixed-top expanded" id="sidebar-wrapper" role="navigation">
	<ul class="nav sidebar-nav">
		<li class="sidebar-brand">
			<a href="{{ route('dashboard') }}">
				<?php include(resource_path('views/svg/bell.svg')) ?>
			</a>
		</li>
		<li>
			<a href="{{ route('dashboard') }}"><i class="material-icons">dashboard</i> <span>{{ trans('base.dashboard') }}</span></a>
		</li>
		<li>
			<a href="{{ route('appointments.index') }}"><i class="material-icons">event</i> <span>{{ trans('base.appointments') }}</span></a>
		</li>
		<li>
			<a href="{{ route('appointmenttypes.index') }}"><i class="material-icons">subject</i> <span>{{ trans('base.appointment_types') }}</span></a>
		</li>
		@if (Auth::user()->role == Auth::user()->role('admin'))
			<li>
				<a href="{{ route('companies.index') }}"><i class="material-icons">extension</i> <span>{{ trans('base.companies') }}</span></a>
			</li>
		@endif
		<li>
			<a href="{{ route('users.index') }}"><i class="material-icons">account_circle</i> <span>{{ trans('base.accounts') }}</span></a>
		</li>
		<li>
			<a href="{{ route('customers.index') }}"><i class="material-icons">book</i> <span>{{ trans('base.customers') }}</span></a>
		</li>
		<li>
			<a href="{{ route('company.index') }}"><i class="material-icons">settings</i> <span>{{ trans('base.settings') }}</span></a>
		</li>
	</ul>
</nav>
