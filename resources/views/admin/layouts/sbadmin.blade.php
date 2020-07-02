<!DOCTYPE html>
<html lang="es">
	<head>
		@include('admin.layouts.sections.metas')
		<title>{{ env('APP_NAME') }} @yield('title')</title>
		@include('admin.layouts.sections.styles')
		@yield('styles')
		<script>
			var direction = "{{ env('APP_URL') }}";
		</script>
	</head>
	<body id="page-top">
		<!-- Page Wrapper -->
		<div id="wrapper">
			<!-- Sidebar -->
			@include('admin.layouts.sections.sidebar')
			<!-- End of Sidebar -->
			<!-- Content Wrapper -->
			<div id="content-wrapper" class="d-flex flex-column">
				<!-- Main Content -->
				<div id="content">
					<!-- Topbar -->
					@include('admin.layouts.sections.topbar')
					<!-- End of Topbar -->
					<!-- Begin Page Content -->
					<div class="container-fluid">
						<!-- Page Heading -->
						<div class="row">
							<div class="col-12">
								<h1 class="h3 mb-1 text-gray-800">@yield('page-header')</h1>
								<p class="mb-4">@yield('panel-heading')</p>
							</div>
						</div>
						@include('admin.layouts.sections.alerts')
						@yield('content')
					</div>
					<!-- /.container-fluid -->
				</div>
				<!-- End of Main Content -->
				<!-- Footer -->
				@include('admin.layouts.sections.footer')
				<!-- End of Footer -->
			</div>
			<!-- End of Content Wrapper -->
		</div>
		<!-- End of Page Wrapper -->
		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>
		<!-- Logout Modal-->
		@include('admin.layouts.modals.logout_modal')
		@if($view == 'sales')
			@include('admin.layouts.modals.delete_modal')
		@endif
		@if(($active == 'finances' || $active == 'buildings' || $active == 'shippings') && isset($item) && $view != 'show')
			@include('admin.layouts.modals.return_modal')
		@endif
		<!-- Other Modals-->
		@yield('modals')
		@include('admin.layouts.sections.scripts')
		@yield('scripts')
	</body>
</html>
