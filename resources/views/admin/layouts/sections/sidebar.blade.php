<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-laugh-wink"></i>
		</div>
		<div class="sidebar-brand-text mx-3">{{ env('APP_NAME') }}</div>
	</a>
	<!-- Divider -->
	<hr class="sidebar-divider my-0">
	<!-- Nav Item - Dashboard -->
	<li class="nav-item">
		<a class="nav-link" href="index.html">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>{{ trans('crud.dashboard') }}</span>
		</a>
	</li>
	<!-- Divider -->
	<hr class="sidebar-divider">
	<!-- Heading -->
	<div class="sidebar-heading">
		{{ trans('crud.management') }}
	</div>
	<!-- Admin Modules -->
	@include('admin.layouts.sections.sidebar_admin_modules')
	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">
	<!-- General Modules -->
	@include('admin.layouts.sections.sidebar_general_modules')
	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>
</ul>