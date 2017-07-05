<!DOCTYPE html>
<html>
<head>
	<title>
		@section('title')
		IDNA - BG APP
		@show
	</title>
	<meta name="token" content="{{ Session::token() }}">

	<link rel="stylesheet" type="text/css" href="/kickstart/css/kickstart.css">

	@yield('styles')

	<script type="text/javascript" src="/kickstart/js/kickstart.js"></script>

	@yield('scripts')
</head>
<body>

	<div id="content">
		@yield('content')
	</div>
</body>
</html>
