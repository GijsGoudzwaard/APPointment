<div class="topbar">

	<div class="user">
		<div class="avatar" style="background-image: url({{ url(Auth::user()->avatar ?: 'assets/img/default_avatar.png') }})"></div>
		<span>{{ Auth::user()->firstname . ' ' . Auth::user()->surname }}</span>
		<ul>
			<li><a href="{{ route('users.edit', Auth::user()->id) }}">{{ trans('base.account_settings') }}</a></li>
			<li class="language-switcher">
				<a href="javascript:;">{{ trans('base.language') }}: <strong>{{ strtoupper(app()->getLocale() ?? \Cookie::get('lang')) }}</strong></a>
				<ul>
					@foreach (get_locales() as $locale)
						<li><a href="{{ route('setlanguage', $locale) }}">{{ trans('languages.' . $locale) }}</a></li>
					@endforeach
				</ul>
			</li>
			<li><a href="{{ route('auth.logout') }}">{{ trans('base.logout') }}</a></li>
		</ul>
	</div>

</div>
