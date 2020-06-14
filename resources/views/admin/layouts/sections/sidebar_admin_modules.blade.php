@if(Sentinel::getUser()->role_id == 1)
	{{-- Users --}}
	@php
	    $route_module = 'users';
	@endphp
	<!-- Nav Item - Pages Collapse Menu -->
	@include('admin.layouts.sections.sidebar_module_template')
@endif
@if(Sentinel::getUser()->role_id == 1 || Sentinel::getUser()->role_id == 2)
	{{-- Sales --}}
	@php
	    $route_module = 'sales';
	@endphp
	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'active' : '') !!}">
		<a class="nav-link {!! (Request::is($route_module) || Request::is($route_module.'/*') ? '' : 'collapsed') !!}" href="#" data-toggle="collapse" data-target="#collapse{{ trans('module_'.$route_module.'.controller.model') }}" aria-expanded="true" aria-controls="collapse{{ trans('module_'.$route_module.'.controller.model') }}">
			<i class="fas fa-fw fa-{{ trans('module_'.$route_module.'.sidebar.route_font_awesome') }}"></i>
			<span>{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}</span>
		</a>
		<div id="collapse{{ trans('module_'.$route_module.'.controller.model') }}" class="collapse {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'show' : '') !!}" aria-labelledby="heading{{ trans('module_'.$route_module.'.controller.model') }}" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">{{ trans('crud.manage') }} {{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}:</h6>
				<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module) !!}">{{ trans('module_'.$route_module.'.sidebar.title') }}</a>
				<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module.'.finished') !!}">{{ trans('module_'.$route_module.'.sidebar.finished') }}</a>
			</div>
		</div>
	</li>
@endif
@if(Sentinel::getUser()->role_id == 1 || Sentinel::getUser()->role_id == 3)
	{{-- Finances --}}
	@php
	    $route_module = 'finances';
	@endphp
	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'active' : '') !!}">
		<a class="nav-link {!! (Request::is($route_module) || Request::is($route_module.'/*') ? '' : 'collapsed') !!}" href="#" data-toggle="collapse" data-target="#collapse{{ trans('module_'.$route_module.'.controller.model') }}" aria-expanded="true" aria-controls="collapse{{ trans('module_'.$route_module.'.controller.model') }}">
			<i class="fas fa-fw fa-{{ trans('module_'.$route_module.'.sidebar.route_font_awesome') }}"></i>
			<span>{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}</span>
		</a>
		<div id="collapse{{ trans('module_'.$route_module.'.controller.model') }}" class="collapse {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'show' : '') !!}" aria-labelledby="heading{{ trans('module_'.$route_module.'.controller.model') }}" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">{{ trans('crud.manage') }} {{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}:</h6>
				<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module) !!}">{{ trans('crud.sidebar.list') }}</a>
				<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module.'.finished') !!}">{{ trans('module_'.$route_module.'.sidebar.finished') }}</a>
			</div>
		</div>
	</li>
@endif
@if(Sentinel::getUser()->role_id == 1 || Sentinel::getUser()->role_id == 5)
	{{-- Buildings --}}
	@php
	    $route_module = 'buildings';
	@endphp
	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'active' : '') !!}">
		<a class="nav-link {!! (Request::is($route_module) || Request::is($route_module.'/*') ? '' : 'collapsed') !!}" href="#" data-toggle="collapse" data-target="#collapse{{ trans('module_'.$route_module.'.controller.model') }}" aria-expanded="true" aria-controls="collapse{{ trans('module_'.$route_module.'.controller.model') }}">
			<i class="fas fa-fw fa-{{ trans('module_'.$route_module.'.sidebar.route_font_awesome') }}"></i>
			<span>{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}</span>
		</a>
		<div id="collapse{{ trans('module_'.$route_module.'.controller.model') }}" class="collapse {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'show' : '') !!}" aria-labelledby="heading{{ trans('module_'.$route_module.'.controller.model') }}" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">{{ trans('crud.manage') }} {{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}:</h6>
				<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module) !!}">{{ trans('crud.sidebar.list') }}</a>
				<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module.'.finished') !!}">{{ trans('module_'.$route_module.'.sidebar.finished') }}</a>
			</div>
		</div>
	</li>
@endif
@if(Sentinel::getUser()->role_id == 1 || Sentinel::getUser()->role_id == 5)
	{{-- Shippings --}}
	@php
	    $route_module = 'shippings';
	@endphp
	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'active' : '') !!}">
		<a class="nav-link {!! (Request::is($route_module) || Request::is($route_module.'/*') ? '' : 'collapsed') !!}" href="#" data-toggle="collapse" data-target="#collapse{{ trans('module_'.$route_module.'.controller.model') }}" aria-expanded="true" aria-controls="collapse{{ trans('module_'.$route_module.'.controller.model') }}">
			<i class="fas fa-fw fa-{{ trans('module_'.$route_module.'.sidebar.route_font_awesome') }}"></i>
			<span>{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}</span>
		</a>
		<div id="collapse{{ trans('module_'.$route_module.'.controller.model') }}" class="collapse {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'show' : '') !!}" aria-labelledby="heading{{ trans('module_'.$route_module.'.controller.model') }}" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">{{ trans('crud.manage') }} {{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}:</h6>
				<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module) !!}">{{ trans('crud.sidebar.list') }}</a>
				<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module.'.finished') !!}">{{ trans('module_'.$route_module.'.sidebar.finished') }}</a>
			</div>
		</div>
	</li>
	{{-- Deliveries --}}
	@php
	    $route_module = 'deliveries';
	@endphp
	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'active' : '') !!}">
		<a class="nav-link {!! (Request::is($route_module) || Request::is($route_module.'/*') ? '' : 'collapsed') !!}" href="#" data-toggle="collapse" data-target="#collapse{{ trans('module_'.$route_module.'.controller.model') }}" aria-expanded="true" aria-controls="collapse{{ trans('module_'.$route_module.'.controller.model') }}">
			<i class="fas fa-fw fa-{{ trans('module_'.$route_module.'.sidebar.route_font_awesome') }}"></i>
			<span>{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}</span>
		</a>
		<div id="collapse{{ trans('module_'.$route_module.'.controller.model') }}" class="collapse {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'show' : '') !!}" aria-labelledby="heading{{ trans('module_'.$route_module.'.controller.model') }}" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">{{ trans('crud.manage') }} {{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}:</h6>
				<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module) !!}">{{ trans('crud.sidebar.list') }}</a>
				<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module.'.finished') !!}">{{ trans('module_'.$route_module.'.sidebar.finished') }}</a>
			</div>
		</div>
	</li>
	{{-- Almacén --}}
	@php
	    $route_module = '';
	@endphp
	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseAlmacen" aria-expanded="true" aria-controls="collapseAlmacen">
			<i class="fas fa-fw fa-warehouse"></i>
			<span>Almacén</span>
		</a>
		<div id="collapseAlmacen" class="collapse" aria-labelledby="heading" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">{{ trans('crud.manage') }} almacén:</h6>
				<a class="collapse-item" href="#">{{ trans('crud.sidebar.list') }}</a>
			</div>
		</div>
	</li>
	{{-- Paquetes --}}
	@php
	    $route_module = '';
	@endphp
	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePaquetes" aria-expanded="true" aria-controls="collapsePaquetes">
			<i class="fas fa-fw fa-box-open"></i>
			<span>Paquetes</span>
		</a>
		<div id="collapsePaquetes" class="collapse" aria-labelledby="heading" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">{{ trans('crud.manage') }} paquetes:</h6>
				<a class="collapse-item" href="#">{{ trans('crud.sidebar.list') }}</a>
			</div>
		</div>
	</li>
@endif
