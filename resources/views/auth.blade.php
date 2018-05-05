<!DOCTYPE html>
<html>
<head>
	<title>
		@section('title')
		IDNA - BG APP
		@show
	</title>
	<meta name="token" content="{{ Session::token() }}">

	<link rel="stylesheet" href="{{ URL::asset('theme/assets/stylesheets/styles.css') }}">

	@yield('styles')

	<script type="text/javascript" src="{{ URL::asset('jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('theme/assets/scripts/frontend.js') }}"></script>

	@yield('scripts')
</head>
<body>
	@if (count($errors) > 0)
        @foreach ($errors->all() as $error)
        	@include('widgets.alert', array('class'=>'danger', 'dismissable'=>true, 'message'=> $error, 'icon'=> 'remove'))
        @endforeach
    @endif

    @if (isset($custom_errors))
        @foreach ($custom_errors as $error)
        	@include('widgets.alert', array('class'=>'danger', 'dismissable'=>true, 'message'=> $error, 'icon'=> 'remove'))
        @endforeach        
    @endif

    @if (session('success'))
    	@include('widgets.alert', array('class'=>'success', 'dismissable'=>true, 'message'=> session('success'), 'icon'=> 'remove'))
    @endif

    @if (session('error_msg'))
    	@include('widgets.alert', array('class'=>'danger', 'dismissable'=>true, 'message'=> session('error_msg'), 'icon'=> 'remove'))
    @endif

	<div id="content">
		@yield('content')
	</div>
</body>
</html>
