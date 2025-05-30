<x-auth-layout>
    @if (session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
    @endif
    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="{{ route('dashboard') }}" action="{{ route('login') }}">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-gray-900 fw-bolder mb-3">
                {{ __('messages.sign_in') }}
            </h1>
            <!--end::Title-->

            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">
                {{ __('messages.inspirational_sentence') }}
            </div>
            <!--end::Subtitle--->
        </div>
        <!--begin::Heading-->

        <div class="row g-3 d-flex justify-content-center mb-9">
            <!--begin::Col-->
            <div class="col-md-6">
                <!--begin::Google link--->
                <a href="{{ url('auth/google') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                    <img alt="Logo" src="{{ image('svg/brand-logos/google-icon.svg') }}" class="h-15px me-3">
                    {{ __('messages.sign_in_with_google') }}
                </a>
                <!--end::Google link--->
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-md-6">
                <!--begin::Facebook link--->
                <a href="{{ url('auth/facebook') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                    <img alt="Logo" src="{{ image('svg/brand-logos/facebook-4.svg') }}" class="theme-light-show h-15px me-3">
                    <img alt="Logo" src="{{ image('svg/brand-logos/facebook-4.svg') }}" class="theme-dark-show h-15px me-3">
                    {{ __('messages.sign_in_with_facebook') }}
                </a>
                <!--end::Facebook link--->
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-md-6">
                <!--begin::LinkedIn link--->
                <a href="{{ url('auth/linkedin') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                    <img alt="Logo" src="{{ image('svg/brand-logos/linkedin-2.svg') }}" class="theme-light-show h-15px me-3">
                    <img alt="Logo" src="{{ image('svg/brand-logos/linkedin-2.svg') }}" class="theme-dark-show h-15px me-3">
                    {{ __('messages.sign_in_with_linkedin') }}
                </a>
                <!--end::LinkedIn link--->
            </div>
            <!--end::Col-->


        </div>

        <div class="separator separator-content my-14">
            <span class="w-125px text-gray-500 fw-semibold fs-7">{{ __('messages.or_with_email') }}</span>
        </div>

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="{{ __('messages.email') }}" name="email" autocomplete="off" class="form-control bg-transparent" value="" />
            <!--end::Email-->
        </div>

        <!--end::Input group--->
        <div class="fv-row mb-3">
            <!--begin::Password-->
            <input type="password" placeholder="{{ __('messages.password') }}" name="password" autocomplete="off" class="form-control bg-transparent" value="" />
            <!--end::Password-->
        </div>
        <!--end::Input group--->

        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>

            <!--begin::Link-->
            <a href="{{ route('password.request') }}" class="link-primary">
                {{ __('messages.forgot_password') }}
            </a>
            <!--end::Link-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                @include('partials/general/_button-indicator', ['label' => __('messages.sign_in')])
            </button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">
            {{ __('messages.not_a_member_yet') }}

            <a href="{{ route('register') }}" class="link-primary">
                {{ __('messages.sign_up') }}
            </a>
        </div>
        <!--end::Sign up-->
    </form>
    <!--end::Form-->
</x-auth-layout>