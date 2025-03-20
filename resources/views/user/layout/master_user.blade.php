<!DOCTYPE html>
<html lang="en">
<head>
   @include('admin.layout.css')
</head>

	<body class="hold-transition sidebar-mini">
				@include('user.layout.header')
			<!-- /.navbar -->
			@include('user.layout.sidebar_user')
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				@yield('content')
				<!-- /.content -->
			</div>
		@include('user.layout.footer')
		</div>
		@include('user.layout.javascript')
	</body>
</html>