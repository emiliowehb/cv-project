<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<!--begin::Head-->
<head>
    <base href=""/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content=""/>
    <link rel="canonical" href="{{ url()->current() }}"/>

    {!! includeFavicon() !!}

    <!--begin::Fonts-->
    {!! includeFonts() !!}
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    @foreach(getGlobalAssets('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Vendor Stylesheets(used by this page)-->
    @foreach(getVendors('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Vendor Stylesheets-->

    <!--begin::Custom Stylesheets(optional)-->
    @foreach(getCustomCss() as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Custom Stylesheets-->

    @livewireStyles
</head>
<!--end::Head-->

<!--begin::Body-->
<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

@include('partials/theme-mode/_init')

@yield('content')

<!--begin::Javascript-->

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1309235706943062',
      cookie     : true,
      xfbml      : true,
      version    : 'v21.0'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<script>
window.chosenLocale = localStorage.getItem('chosenLocale') || '{{ app()->getLocale() }}';
</script>
<script>
document.addEventListener('DOMContentLoaded', async function() {
    var chosenLocale = localStorage.getItem('chosenLocale') || '{{ app()->getLocale() }}';
    await axios.get(`/locale/${chosenLocale}`)
        .then(response => {
            console.log('Locale set in Laravel', chosenLocale);
        })
        .catch(error => {
            console.error('Error setting locale in Laravel:', error);
        });
    var localeText = {
        'en_US': 'English',
        'fr_FR': 'Français',
        'ar_SA': 'العربية'
    };
    var localeFlag = {
        'en_US': '{{ image('flags/united-states.svg') }}',
        'fr_FR': '{{ image('flags/france.svg') }}',
        'ar_SA': '{{ image('flags/saudi-arabia.svg') }}'
    };

    document.getElementById('current-locale').innerText = localeText[chosenLocale];
    document.getElementById('current-locale-flag').src = localeFlag[chosenLocale];
});
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
@foreach(getGlobalAssets() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Global Javascript Bundle-->

<!--begin::Vendors Javascript(used by this page)-->
@foreach(getVendors('js') as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Vendors Javascript-->

<!--begin::Custom Javascript(optional)-->
@foreach(getCustomJs() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Custom Javascript-->
@stack('scripts')
<!--end::Javascript-->
<script src="resources/mix/vendors/formrepeater/formrepeater.bundle.js"></script>
<script>
    // when the hyperlink with locale-selector class is clicked, we will set the chosen locale to the data-chosen-locale attribute value
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('locale-selector')) {
            e.preventDefault();

            localStorage.setItem('chosenLocale', e.target.getAttribute('data-chosen-locale'));
            window.location.href = e.target.href;
        }
    });
</script>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('success', (message) => {
            toastr.success(message);
        });
        Livewire.on('error', (message) => {
            toastr.error(message);
        });

        Livewire.on('swal', (message, icon, confirmButtonText) => {
            if (typeof icon === 'undefined') {
                icon = 'success';
            }
            if (typeof confirmButtonText === 'undefined') {
                confirmButtonText = 'Ok, got it!';
            }
            Swal.fire({
                text: message,
                icon: icon,
                buttonsStyling: false,
                confirmButtonText: confirmButtonText,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        });
    });
</script>

@livewireScripts
</body>
<!--end::Body-->

</html>
