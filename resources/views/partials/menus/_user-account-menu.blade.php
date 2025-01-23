<!--begin::User account menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <!--begin::Avatar-->
            <div class="symbol symbol-50px me-5">
                @if(Auth::user()->profile_photo_url)
                    <img alt="Logo" src="{{ Auth::user()->profile_photo_url }}"/>
                @else
                    <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::user()->first_name) }}">
                        {{ substr(Auth::user()->first_name, 0, 1) . substr(Auth::user()->last_name, 0, 1) }}
                    </div>
                @endif
            </div>
            <!--end::Avatar-->
            <!--begin::Username-->
            <div class="d-flex flex-column">
                <div class="fw-bold d-flex align-items-center fs-5">
                    {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                    <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">{{ \App\Enums\WorkspaceTypeEnum::from(Auth::user()->workspace->type)->label() }}</span>
                    @if(Auth::user()->workspace->owner_id == Auth::user()->id)
                        <span class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Workspace Owner">{!! getIcon('crown', 'fs-3 text-warning') !!}</span>
                    @endif
                </div>
                <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
            </div>
            <!--end::Username-->
        </div>
    </div>
    <!--end::Menu item-->
    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->
    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a href="#" class="menu-link px-5">My Profile</a>
    </div>
    <!--end::Menu item-->
    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->
    <!--begin::Menu item-->
    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
        <a href="#" class="menu-link px-5">
			<span class="menu-title position-relative">{{__('messages.mode')}} 
			<span class="ms-5 position-absolute translate-middle-y top-50 end-0">{!! getIcon('night-day', 'theme-light-show fs-2') !!} {!! getIcon('moon', 'theme-dark-show fs-2') !!}</span></span>
		</a>
		@include('partials/theme-mode/__menu')
	</div>
	<!--end::Menu item-->
	<!--begin::Menu item-->
	<div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
        <a href="#" class="menu-link px-5">
            <span class="menu-title position-relative">{{__('messages.language')}} 
            <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                <span id="current-locale"></span>
                <img class="w-15px h-15px rounded-1 ms-2" id="current-locale-flag" src="{{ image('flags/united-states.svg') }}" alt="" />
            </span>
            </span>
        </a>
        <!--begin::Menu sub-->
        <div class="menu-sub menu-sub-dropdown w-175px py-4">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="{{ route('locale', ['locale' => 'en_US']) }}" class="menu-link d-flex px-5 locale-selector {{ app()->getLocale() == 'en_US' ? 'active' : '' }}" data-chosen-locale="en_US">
                    <span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="{{ image('flags/united-states.svg') }}" alt=""/>
                    </span>
                     {{__('messages.english')}}
                </a>
            </div>
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="{{ route('locale', ['locale' => 'fr_FR']) }}" class="menu-link d-flex px-5 locale-selector {{ app()->getLocale() == 'fr_FR' ? 'active' : '' }}" data-chosen-locale="fr_FR">
                    <span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="{{ image('flags/france.svg') }}" alt=""/>
                    </span>
                     {{__('messages.french')}}
                </a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="{{ route('locale', ['locale' => 'ar_SA']) }}" class="menu-link d-flex px-5 locale-selector {{ app()->getLocale() == 'ar_SA' ? 'active' : '' }}" data-chosen-locale="ar_SA">
                    <span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="{{ image('flags/saudi-arabia.svg') }}" alt=""/>
                    </span>
                     {{__('messages.arabic')}}
                </a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::Menu sub-->
    </div>
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <div class="menu-item px-5 my-1">
        <a href="#" class="menu-link px-5">Account Settings</a>
    </div>
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a class="button-ajax menu-link px-5" href="#" data-action="{{ route('logout') }}" data-method="post" data-csrf="{{ csrf_token() }}" data-reload="true">
            Sign Out
        </a>
    </div>
    <!--end::Menu item-->
</div>
<!--end::User account menu-->
