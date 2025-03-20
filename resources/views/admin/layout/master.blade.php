<!DOCTYPE html>
<html lang="en">
<head>
   @include('admin.layout.css')
</head>

	<body class="hold-transition sidebar-mini">
				@include('admin.layout.header')
			<!-- /.navbar -->
			@include('admin.layout.sidebar')
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				@yield('content')
				<!-- /.content -->
			</div>
		@include('admin.layout.footer')
		</div>
		@include('admin.layout.javascript')
	</body>
</html>