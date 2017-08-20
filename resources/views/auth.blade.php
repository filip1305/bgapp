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

	<script type="text/javascript" src="{{ URL::asset('jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('/kickstart/js/kickstart.js') }}"></script>

	@yield('scripts')
</head>
<body>

	@if (count($errors) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div class="notice error">
                	<i class="fa fa-remove"></i>{{ $error }}
				</div>
            @endforeach
        </div>
    @endif

	<div id="content">
		@yield('content')
	</div>
</body>
</html>
