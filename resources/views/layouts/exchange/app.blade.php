@include('include.exchange.top')

@yield('content')

<div id="app"></div>

<input type="hidden" name="user_api_token" id="user_api_token" value="{{ Auth::user()->api_token }}">


@include('include.exchange.footerjs')
