<div class="web-one">
	<nav class="navbar navbar-default" role="navigation">
		<div class="container hidden-xs">
			<div class="row">
				<div class="col-sm-5 col-md-6 col-lg-7">
					<a class="navbar-brand hidden-xs" href="http://www.csun.edu">
						<img src="{{ asset('imgs/csun-logo.png')}}" alt="California State University, Northridge - CSUN">
					</a>
					<a class="navbar-brandname hidden-xs" href="{{ url('/') }}">
						<img src="{{ asset('imgs/faculty-logo.png')}}" alt="META Lab Faculty Application">
					</a>
				</div>
				<ul class="list-inline mini-nav pull-right">
					<li><a href="#main-content">Skip to content</a></li>|
					<li><a href="http://www.csun.edu/universaldesigncenter">Accessibility</a></li>|
					<li><a href="https://mynorthridge.csun.edu/psc/PANRPRD/EMPLOYEE/EMPL/c/NRPA_CSUN_APPS.NR_PEOPLESRCH_CMP.GBL">Directory</a></li>|
					<li><a href="http://www.csun.edu/calendar">Calendar</a></li>|
					<li><a href="http://www.csun.edu/atoz/">A to Z</a></li>|
					<li><a href="http://www.csun.edu/it/webmail">Webmail</a></li>
				</ul>
			</div>
		</div>
		<div class="navbar-bg">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand hidden-sm hidden-md hidden-lg" style="margin-top: 10px;" href="{{ url('/') }}"><img src="{{ asset('imgs/csun-logo.png')}}" alt="CSUN Faculty Logo"></a>
				<a class="navbar-brand hidden-sm hidden-md hidden-lg" style="margin-top: 1px;" href="{{ url('/') }}"><img src="{{ asset('imgs/faculty-logo-sm.png')}}" alt="CSUN Faculty Logo"></a>
			</div>
			<div class="navbar-body">
				<div class="container">
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-ex1-collapse">
						<ul class="nav navbar-nav navbar-center">
							<li><a href="{{ url('/') }}">Home</a></li>
							<li class="{{ setActive(['search']) }}"><a href="{{ url('search') }}">Profiles</a></li>
							<li class="{{ setActive('stories') }}"><a href="{{ env('STORIES_APP_URL') }}">Stories</a></li>
							<li class="{{ setActive(['scholarship']) }}"><a href="{{ env('HELIX_APP_URL') }}">Scholarship</a></li>
							<li class="{{ setActive(['support','about/*']) }}"><a href="{{ url('about/version-history') }}">About</a></li>
							
							@if(session('mask') == true)
								<li class="{{ setActive(['switch']) }}"><a href="{{ url('switch') }}">Switch Back</a></li>
							@else
								@if (Auth::check())
									<li class="{{ setActive(['logout']) }}"><a href="{{ url('logout') }}">Logout</a></li>
								@else
									<li class="{{ setActive(['login']) }}"><a href="{{ secure_url('login') }}">Login</a></li>
								@endif
							@endif
						</ul>
					</div><!-- /.navbar-collapse -->
				</div>
			</div>
		</div>
	</nav>
</div>
