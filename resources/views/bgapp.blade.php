<!DOCTYPE html>
<html>
<head>
	<title>
		@section('title')
		IDNA - BG APP
		@show
	</title>
	<meta name="token" content="{{ Session::token() }}">

	<link rel="stylesheet" href="{{ URL::asset('/datatables/media/css/jquery.dataTables.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('theme/assets/stylesheets/styles.css') }}">

	@yield('styles')

	<script type="text/javascript" src="{{ URL::asset('jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('theme/assets/scripts/frontend.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('/datatables/media/js/jquery.dataTables.min.js') }}"></script>
	
	@yield('scripts')
</head>
<body>
	<div id="wrapper">

		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	        <div class="navbar-header">
	        	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
	            <a class="navbar-brand" href="{{ url ('') }}">IDNA Boardgame App</a>
	        </div>

	        <ul class="nav navbar-top-links navbar-right">
	        	<li><a href="/auth/logout"><i class="fa fa-power-off fa-fw"></i></a></li>
	        </ul>

	        <div class="navbar-default sidebar" role="navigation">
	            <div class="sidebar-nav navbar-collapse">
	                <ul class="nav" id="side-menu">
	                    <li>
	                        <a href="{{ url ('boardgames') }}"><i class="fa fa-rebel fa-fw"></i> Boardgames</a>
	                    </li>
	                    <li>
	                        <a href="{{ url ('expansions') }}"><i class="fa fa-empire fa-fw"></i> Expansions</a>
	                    </li>
	                    <li>
	                        <a href="{{ url ('games') }}"><i class="fa fa-bomb fa-fw"></i> Games</a>
	                    </li>
	                    <li>
	                        <a href="#"><i class="fa fa-users fa-fw"></i> Users<span class="fa arrow"></span></a>
	                        <ul class="nav nav-second-level">
	                        	<li>
	                                <a href="{{ url ('users') }}"><i class="fa fa-users fa-fw"></i> All Users</a>
	                            </li>
	                        	<li>
	                                <a href="{{ url ('user/view_me' ) }}"><i class="fa fa-user fa-fw"></i> My Profile</a>
	                            </li>
	                        </ul>
	                    </li>
	                </ul>
	            </div>
	        </div>
	    </nav>

	    <div id="page-wrapper">
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

			<div class="row">  
				@yield('content')
            </div>
        </div>
	</div>
</body>
</html>
