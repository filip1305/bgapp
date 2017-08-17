<!DOCTYPE html>
<html>
<head>
	<title>
		@section('title')
		IDNA - BG APP
		@show
	</title>
	<meta name="token" content="{{ Session::token() }}">

	<link rel="stylesheet" href="{{ URL::asset('/kickstart/css/kickstart.css') }}">

	@yield('styles')

	<script type="text/javascript" src="{{ URL::asset('/kickstart/js/kickstart.js') }}"></script>

	@yield('scripts')
</head>
<body>

	<ul class="menu">
		<li><a href="/boardgames">Boardgames</a></li>
		<li><a href="/expansions">Expansions</a></li>
	</ul>

	<div id="content">
		@yield('content')
	</div>
</body>
</html>
