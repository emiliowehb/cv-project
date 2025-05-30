<!--begin::Menu wrapper-->
<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
	<!--begin::Menu-->
	<div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
		<!--begin:Menu item-->
		<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-0 me-lg-2">
			<!--begin:Menu link-->
			<a href="{{route('dashboard')}}" class="menu-link">
				<span class="menu-title">Dashboard</span>
			</a>
			<!--end:Menu link-->
			<!--begin:Menu sub-->
			<!-- <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0"> -->
			{{-- @include(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/header/_menu/__pages') --}}
			<!-- </div> -->
			<!--end:Menu sub-->
		</div>
		<!--end:Menu item-->
		<!--begin:Menu item-->
		@if(auth()->user()->professor)
		<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-0 me-lg-2">
			<!--begin:Menu link-->
			<a href="{{ route('professors.my-profile.overview') }}" class="menu-link">
				<span class="menu-title">My Profile</span>
			</a>
			<!--end:Menu link-->
			<!--begin:Menu sub-->
			<!-- <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0"> -->
			{{-- @include(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/header/_menu/__pages') --}}
			<!-- </div> -->
			<!--end:Menu sub-->
		</div>
		@endif
		<!--end:Menu item-->
				<!--begin:Menu item-->
				@if(auth()->user()->professor)
		<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-0 me-lg-2">
			<!--begin:Menu link-->
			<a href="{{ route('professors.cv-builder') }}" class="menu-link">
				<span class="menu-title">CV Builder</span>
			</a>
			<!--end:Menu link-->
			<!--begin:Menu sub-->
			<!-- <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0"> -->
			{{-- @include(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/header/_menu/__pages') --}}
			<!-- </div> -->
			<!--end:Menu sub-->
		</div>
		@endif
		<!--end:Menu item-->
	</div>
	<!--end::Menu-->
</div>
<!--end::Menu wrapper-->