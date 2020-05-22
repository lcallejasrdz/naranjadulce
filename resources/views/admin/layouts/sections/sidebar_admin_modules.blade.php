{{-- Users --}}
@php
    $route_module = 'users';
@endphp
<!-- Nav Item - Pages Collapse Menu -->
@include('admin.layouts.sections.sidebar_module_template')
{{-- Sales --}}
@php
    $route_module = 'sales';
@endphp
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'active' : '') !!}">
	<a class="nav-link {!! (Request::is($route_module) || Request::is($route_module.'/*') ? '' : 'collapsed') !!}" href="#" data-toggle="collapse" data-target="#collapse{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}" aria-expanded="true" aria-controls="collapse{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}">
		<i class="fas fa-fw fa-{{ trans('module_'.$route_module.'.sidebar.route_font_awesome') }}"></i>
		<span>{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}</span>
	</a>
	<div id="collapse{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}" class="collapse {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'show' : '') !!}" aria-labelledby="heading{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}" data-parent="#accordionSidebar">
		<div class="bg-white py-2 collapse-inner rounded">
			<h6 class="collapse-header">{{ trans('crud.manage') }} {{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}:</h6>
			<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module) !!}">{{ trans('crud.sidebar.list') }}</a>
		</div>
	</div>
</li>
{{-- Finances --}}
@php
    $route_module = 'finances';
@endphp
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'active' : '') !!}">
	<a class="nav-link {!! (Request::is($route_module) || Request::is($route_module.'/*') ? '' : 'collapsed') !!}" href="#" data-toggle="collapse" data-target="#collapse{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}" aria-expanded="true" aria-controls="collapse{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}">
		<i class="fas fa-fw fa-{{ trans('module_'.$route_module.'.sidebar.route_font_awesome') }}"></i>
		<span>{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}</span>
	</a>
	<div id="collapse{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}" class="collapse {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'show' : '') !!}" aria-labelledby="heading{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}" data-parent="#accordionSidebar">
		<div class="bg-white py-2 collapse-inner rounded">
			<h6 class="collapse-header">{{ trans('crud.manage') }} {{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}:</h6>
			<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module) !!}">{{ trans('crud.sidebar.list') }}</a>
		</div>
	</div>
</li>
{{-- Buildings --}}
@php
    $route_module = 'buildings';
@endphp
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'active' : '') !!}">
	<a class="nav-link {!! (Request::is($route_module) || Request::is($route_module.'/*') ? '' : 'collapsed') !!}" href="#" data-toggle="collapse" data-target="#collapse{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}" aria-expanded="true" aria-controls="collapse{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}">
		<i class="fas fa-fw fa-{{ trans('module_'.$route_module.'.sidebar.route_font_awesome') }}"></i>
		<span>{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}</span>
	</a>
	<div id="collapse{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}" class="collapse {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'show' : '') !!}" aria-labelledby="heading{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}" data-parent="#accordionSidebar">
		<div class="bg-white py-2 collapse-inner rounded">
			<h6 class="collapse-header">{{ trans('crud.manage') }} {{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}:</h6>
			<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module) !!}">{{ trans('crud.sidebar.list') }}</a>
		</div>
	</div>
</li>
{{-- Shippings --}}
@php
    $route_module = 'shippings';
@endphp
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'active' : '') !!}">
	<a class="nav-link {!! (Request::is($route_module) || Request::is($route_module.'/*') ? '' : 'collapsed') !!}" href="#" data-toggle="collapse" data-target="#collapse{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}" aria-expanded="true" aria-controls="collapse{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}">
		<i class="fas fa-fw fa-{{ trans('module_'.$route_module.'.sidebar.route_font_awesome') }}"></i>
		<span>{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}</span>
	</a>
	<div id="collapse{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}" class="collapse {!! (Request::is($route_module) || Request::is($route_module.'/*') ? 'show' : '') !!}" aria-labelledby="heading{{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}" data-parent="#accordionSidebar">
		<div class="bg-white py-2 collapse-inner rounded">
			<h6 class="collapse-header">{{ trans('crud.manage') }} {{ trans('module_'.$route_module.'.sidebar.route_title_plural') }}:</h6>
			<a class="collapse-item {!! (Request::is($route_module) ? 'active' : '') !!}" href="{!! URL::route($route_module) !!}">{{ trans('crud.sidebar.list') }}</a>
		</div>
	</div>
</li>
