@include('include.exchange.top')

@yield('content')

<div id="app"></div>

<input type="hidden" name="user_api_token" id="user_api_token" value="{{ Auth::user()->api_token }}">
<input type="hidden" name="user_currency_code" id="user_currency_code" value="{{ Auth::user()->currencyCode }}">
<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">


@include('include.exchange.footerjs')
