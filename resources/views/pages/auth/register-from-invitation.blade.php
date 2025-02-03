<x-auth-layout>

    <!--begin::Form-->
    <form class="form w-100 " novalidate="novalidate" id="kt_sign_up_form" data-kt-redirect-url="{{ route('login') }}" action="{{ route('register.invite.post') }}">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-gray-900 fw-bolder mb-3">
                {{ __('messages.sign_up') }}
            </h1>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">
                {{ __('messages.inspirational_sentence') }}
            </div>
            <!--end::Subtitle--->
        </div>

        <div class="separator separator-content my-14">
            <span class="w-125px text-gray-500 fw-semibold fs-7">{{ __('messages.or_with_email') }}</span>
        </div>

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Name-->
            <input type="text" placeholder="{{ __('messages.first_name') }}" name="first_name" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Name-->
        </div>
        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Name-->
            <input type="text" placeholder="{{ __('messages.last_name') }}" name="last_name" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Name-->
        </div>

        <input type="hidden" name="invitation_code" value="{{request()->invite_code}}">

        <input type="hidden" name="selected_email" value="{{request()->email}}">

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="{{ __('messages.email') }}" name="email" autocomplete="off" class="form-control bg-transparent" value="{{request()->email}}" disabled/>
            <!--end::Email-->
        </div>

        <!--begin::Input group-->
        <div class="fv-row mb-8" data-kt-password-meter="true">
            <!--begin::Wrapper-->
            <div class="mb-1">
                <!--begin::Input wrapper-->
                <div class="position-relative mb-3">
                    <input class="form-control bg-transparent" type="password" placeholder="{{ __('messages.password') }}" name="password" autocomplete="off" />

                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                <!--end::Input wrapper-->

                <!--begin::Meter-->
                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div>
                <!--end::Meter-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Hint-->
            <div class="text-muted">
                {{ __('messages.password_hint') }}
            </div>
            <!--end::Hint-->
        </div>
        <!--end::Input group--->

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Repeat Password-->
            <input placeholder="{{ __('messages.confirm_password') }}" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Repeat Password-->
        </div>
        <!--end::Input group--->

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <label class="form-label text-muted required">{{ __('messages.subscription_type') }}</label>
            <select class="form-control bg-transparent" name="subscription_type" id="subscription_type" disabled>
                <optgroup label="{{ __('messages.individual_subscription') }}">
                    <option value="individual">{{ __('messages.individual') }}</option>
                </optgroup>
                <optgroup label="{{ __('messages.enterprise_subscription') }}">
                    <option value="institution" selected>{{ __('messages.institution') }}</option>
                </optgroup>
            </select>
        </div>
        <!--end::Input group--->

        <!--begin::Input group--->
        <div class="form-group enterprise-options">
            <label class="form-check-label fw-semibold text-muted fs-6">{{ __('messages.already_have_invite') }}</label>
            <div class="fv-row mb-8">
                <!--begin::Invite Code-->
                <input type="text" placeholder="{{ __('messages.institutional_invite_code') }}" name="invite_code" autocomplete="off" class="form-control bg-transparent" id="invite_code" value="{{request()->invite_code}}" disabled/>
                <!--end::Invite code-->
            </div>
        </div>
        <!--end::Input group--->


        <!--begin::Input group--->
        <div class="fv-row mb-10">
            <div class="form-check form-check-custom form-check-solid form-check-inline">
                <input class="form-check-input" type="checkbox" name="toc" value="1" />

                <label class="form-check-label fw-semibold text-gray-700 fs-6">
                    {{ __('messages.agree_terms') }}

                    <a href="#" class="link-primary">{{ __('messages.terms_conditions') }}</a>.
                </label>
            </div>
        </div>
        <!--end::Input group--->

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                @include('partials/general/_button-indicator', ['label' => __('messages.sign_up')])
            </button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">
            {{ __('messages.already_a_member') }}

            <a href="/login" class="link-primary fw-semibold">
                {{ __('messages.sign_in') }}
            </a>
        </div>
        <!--end::Sign up-->
    </form>
    <!--end::Form-->
</x-auth-layout>