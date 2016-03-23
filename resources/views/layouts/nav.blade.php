<nav class="navbar navbar-fixed-top {{ isset($_COOKIE['smallMenu']) ? 'expanded' : '' }}" id="sidebar-wrapper" role="navigation">
	<ul class="nav sidebar-nav">
		<li class="sidebar-brand" style="background-image:url({{ url(get_environment()->company->logo ?? '') }});">
			<a href="{{ url('/') }}"></a>
		</li>
		<li>
			<a href="{{ url('/') }}" title="Dashboard"><i class="material-icons">dashboard</i> <span>Dashboard</span></a>
		</li>
		<li>
			<a href="{{ url('appointments') }}" title="Appointments"><i class="material-icons">description</i> <span>Appointments</span></a>
		</li>
		<li>
			<a href="{{ url('appointmenttypes') }}" title="Appointment types"><i class="material-icons">subject</i> <span>Appointment types</span></a>
		</li>
		@if (Auth::user()->role == 1)
			<li>
				<a href="{{ url('environments') }}" title="Environments"><i class="material-icons">extension</i> <span>Environments</span></a>
			</li>
		@endif
		<li>
			<a href="{{ url('users') }}" title="Accounts"><i class="material-icons">account_circle</i> <span>Accounts</span></a>
		</li>
		<li>
			<a href="{{ url('customers') }}" title="Customers"><i class="material-icons">book</i> <span>Customers</span></a>
		</li>
		<li>
			<a href="{{ url('company') }}" title="Company"><i class="material-icons">settings</i> <span>Company</span></a>
		</li>
	</ul>
</nav>
