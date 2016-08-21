<div class="topbar {{ isset($_COOKIE['smallMenu']) ? 'expanded' : '' }}">

	<a href="javascript:;" class="hamburger-menu"><i class="material-icons">menu</i></a>

	<div class="user">
		<div class="avatar" style="background-image: url({{ url(Auth::user()->avatar ?: 'assets/img/default_avatar.png') }})"></div>
		<span>{{ Auth::user()->firstname . ' ' . Auth::user()->surname }}</span>
		<ul>
			<li><a href="{{ route('users.edit', Auth::user()->id) }}">Account settings</a></li>
			<li class="language-switcher">
				<a href="javascript:;">Language: <strong>NL</strong></a>
				<ul>
					@foreach (get_locales() as $locale)
						<li><a href="{{ $locale }}">{{ trans('languages.' . $locale) }}</a></li>
					@endforeach
				</ul>
			</li>
			<li><a href="{{ route('auth.logout') }}">Logout</a></li>
		</ul>
	</div>

</div>
