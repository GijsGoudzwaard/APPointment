<nav class="navbar navbar-fixed-top" id="sidebar-wrapper" role="navigation">
	<ul class="nav sidebar-nav">
		<li class="sidebar-brand" style="background-image:url({{ get_environment()->company->logo ?? '' }});">
			<a href="{{ url('/') }}"></a>
		</li>
		<li>
			<a href="{{ url('/') }}"><i class="material-icons">dashboard</i> <span>Dashboard</span></a>
		</li>
		<li>
			<a href="{{ url('appointments') }}"><i class="material-icons">description</i> <span>Appointments</span></a>
		</li>
		<li>
			<a href="{{ url('environments') }}"><i class="material-icons">extension</i> <span>Environments</span></a>
		</li>
		<li>
			<a href="{{ url('users') }}"><i class="material-icons">account_circle</i> <span>Accounts</span></a>
		</li>
		<li>
			<a href="{{ url('customers') }}"><i class="material-icons">book</i> <span>Customers</span></a>
		</li>
		<li>
			<a href="{{ url('company') }}"><i class="material-icons">settings</i> <span>Company</span></a>
		</li>
	</ul>
</nav>
