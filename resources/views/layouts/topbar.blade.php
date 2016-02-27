<div class="topbar {{ isset($_COOKIE['smallMenu']) ? 'expanded' : '' }}">

	<a href="javascript:;" class="hamburger-menu"><i class="material-icons">menu</i></a>

	<div class="user">
		<ul>
			<li><a href="{{ url('') }}">Account settings</a></li>
			<li><a href="{{ url('logout') }}">Logout</a></li>
		</ul>
	</div>

</div>
