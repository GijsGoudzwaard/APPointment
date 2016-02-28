<div class="topbar {{ isset($_COOKIE['smallMenu']) ? 'expanded' : '' }}">

	<a href="javascript:;" class="hamburger-menu"><i class="material-icons">menu</i></a>

	<div class="user">
		<div class="avatar" style="background-image: url({{ url(Auth::user()->avatar) }})"></div>
		<span>{{ Auth::user()->name }}</span>
		<ul>
			<li><a href="{{ url('users/' . Auth::user()->id . '/edit') }}">Account settings</a></li>
			<li><a href="{{ url('logout') }}">Logout</a></li>
		</ul>
	</div>

</div>
