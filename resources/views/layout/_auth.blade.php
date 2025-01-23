@extends('layout.master')

@section('content')

<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Wrapper-->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
            <!--begin::Form-->
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <!--begin::Wrapper-->
                <div class="w-lg-500px p-10">
                    <!--begin::Page-->
                    {{ $slot }}
                    <!--end::Page-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Form-->

            <!--begin::Footer-->
            <div class="d-flex flex-center flex-wrap px-5">
                <div class="w-lg-500px d-flex flex-stack px-10 mx-auto">
                    <!--begin::Languages-->
                    <div class="me-10">
                        <!--begin::Toggle-->
                        <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                            <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{ image('flags/' . ([
                                'en_US' => 'united-states',
                                'fr_FR' => 'france',
                                'ar_SA' => 'saudi-arabia',
                                'es_ES' => 'spain'
                            ][app()->getLocale()] ?? 'united-states') . '.svg') }}" alt="">

                            <span data-kt-element="current-lang-name" class="me-1">
                                @switch(app()->getLocale())
                                    @case('en_US')
                                        English
                                        @break
                                    @case('fr_FR')
                                        French
                                        @break
                                    @case('ar_SA')
                                        Arabic
                                        @break
                                    @default
                                        English
                                @endswitch
                            </span>

                            <span class="d-flex flex-center rotate-180">
                                <i class="ki-duotone ki-down fs-5 text-muted m-0"></i> </span>
                        </button>
                        <!--end::Toggle-->

                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu" style="">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ route('locale', ['locale' => 'en_US']) }}" class="menu-link d-flex px-5 locale-selector {{ app()->getLocale() == 'en_US' ? 'active' : '' }}" data-chosen-locale="en_US">
                                    <span class="symbol symbol-20px me-4">
                                        <img class="rounded-1" src="{{ image('flags/united-states.svg') }}" alt="" />
                                    </span>
                                    {{__('messages.english')}}
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ route('locale', ['locale' => 'fr_FR']) }}" class="menu-link d-flex px-5 locale-selector {{ app()->getLocale() == 'fr_FR' ? 'active' : '' }}" data-chosen-locale="fr_FR">
                                    <span class="symbol symbol-20px me-4">
                                        <img class="rounded-1" src="{{ image('flags/france.svg') }}" alt="" />
                                    </span>
                                    {{__('messages.french')}}
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ route('locale', ['locale' => 'ar_SA']) }}" class="menu-link d-flex px-5 locale-selector {{ app()->getLocale() == 'ar_SA' ? 'active' : '' }}" data-chosen-locale="ar_SA">
                                    <span class="symbol symbol-20px me-4">
                                        <img class="rounded-1" src="{{ image('flags/saudi-arabia.svg') }}" alt="" />
                                    </span>
                                    {{__('messages.arabic')}}
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Languages-->

                    <!--begin::Links-->
                    <div class="d-flex fw-semibold text-primary fs-base gap-5">
                        <a href="/metronic8/demo1/pages/team.html" target="_blank">{{ __('messages.terms') }}</a>

                        <a href="/metronic8/demo1/pages/contact.html" target="_blank">{{ __('messages.contact_us') }}</a>
                    </div>
                    <!--end::Links-->
                </div>
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::App-->

@endsection