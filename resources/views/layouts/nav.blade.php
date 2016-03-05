<nav class="navbar navbar-fixed-top {{ isset($_COOKIE['smallMenu']) ? 'expanded' : '' }}" id="sidebar-wrapper" role="navigation">
	<ul class="nav sidebar-nav">
		<li class="sidebar-brand" style="background-image:url({{ url(get_environment()->company->logo ?? '') }});">
			<a href="{{ url('/') }}"></a>
		</li>
		<li>
			<a href="{{ url('/') }}"><i class="material-icons">dashboard</i> <span>Dashboard</span></a>
		</li>
		<li>
			<a href="{{ url('appointments') }}"><i class="material-icons">description</i> <span>Appointments</span></a>
		</li>
		<li>
			<a href="{{ url('appointmenttypes') }}"><i class="material-icons">subject</i> <span>Appointment types</span></a>
		</li>
		@if (Auth::user()->role == 1)
			<li>
				<a href="{{ url('environments') }}"><i class="material-icons">extension</i> <span>Environments</span></a>
			</li>
		@endif
		<li>
			<a href="{{ url('users') }}"><i class="material-icons">account_circle</i> <span>Accounts</span></a>
		</li>
		<li>
			<a href="{{ url('staff') }}"><i class="material-icons">supervisor_account</i> <span>Staff</span></a>
		</li>
		<li>
			<a href="{{ url('customers') }}"><i class="material-icons">book</i> <span>Customers</span></a>
		</li>
		<li>
			<a href="{{ url('company') }}"><i class="material-icons">settings</i> <span>Company</span></a>
		</li>
	</ul>
</nav>
