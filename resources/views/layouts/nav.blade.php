<nav class="navbar navbar-fixed-top {{ isset($_COOKIE['smallMenu']) ? 'expanded' : '' }}" id="sidebar-wrapper" role="navigation">
	<ul class="nav sidebar-nav">
		<li class="sidebar-brand" style="background-image:url({{ asset('assets/img/logo.png') }});">
			<a href="{{ route('dashboard') }}"></a>
		</li>
		<li>
			<a href="{{ route('dashboard') }}" title="Dashboard"><i class="material-icons">dashboard</i> <span>Dashboard</span></a>
		</li>
		<li>
			<a href="{{ route('appointments.index') }}" title="Appointments"><i class="material-icons">description</i> <span>Appointments</span></a>
		</li>
		<li>
			<a href="{{ route('appointmenttypes.index') }}" title="Appointment types"><i class="material-icons">subject</i> <span>Appointment types</span></a>
		</li>
		@if (Auth::user()->role == 1)
			<li>
				<a href="{{ route('companies.index') }}" title="Companies"><i class="material-icons">extension</i> <span>Companies</span></a>
			</li>
		@endif
		<li>
			<a href="{{ route('users.index') }}" title="Accounts"><i class="material-icons">account_circle</i> <span>Accounts</span></a>
		</li>
		<li>
			<a href="{{ route('customers.index') }}" title="Customers"><i class="material-icons">book</i> <span>Customers</span></a>
		</li>
		<li>
			<a href="{{ route('company.index') }}" title="Company"><i class="material-icons">settings</i> <span>Company</span></a>
		</li>
	</ul>
</nav>
