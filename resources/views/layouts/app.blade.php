@inject('request', 'Illuminate\Http\Request')

@if($request->segment(1) == 'pos' && ($request->segment(2) == 'create' || $request->segment(3) == 'edit'))
    @php
        $pos_layout = true;
    @endphp
@else
    @php
        $pos_layout = false;
    @endphp
@endif

@php
    $whitelist = ['127.0.0.1', '::1'];
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ? 'rtl' : 'ltr'}}" class="light">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - {{ Session::get('business.name') }}</title>
        
        @include('layouts.partials.css')

        <!-- custom design css -->
        <link rel="stylesheet" href="{{ asset('style/css/custom.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.css">
        
        <!-- custom design css -->

        @yield('css')
        @if($pos_layout)
            <style> 
                .content {
                    border-radius: 0 !important;
                    padding: 0 !important;
                    min-height: 100vh;
                    min-width: 0;
                    flex: 0 !important;
                    --tw-bg-opacity: 0 !important;
                    background-color: none !important;
                    padding-bottom: 0 !important;
                }
            </style>
        @endif

    </head>

    <body class="@if($pos_layout) hold-transition lockscreen @else hold-transition skin-@if(!empty(session('business.theme_color'))){{session('business.theme_color')}}@else{{'blue-light'}}@endif sidebar-mini @endif py-5">
        @if(!$pos_layout)
        
            <!-- BEGIN: Mobile Menu -->
            <div class="mobile-menu md:hidden">
                <div class="mobile-menu-bar">
                    <a href="" class="flex mr-auto">
                        <img alt="Midone - HTML Admin Template" class="w-6" src="{{ asset('style/images/logo.svg') }}">
                    </a>
                    <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
                </div>
                <div class="scrollable">
                    <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
                        
                    {!! Menu::render('admin-menu', 'adminltemobilecustom'); !!}

                </div>
            </div>
            <!-- END: Mobile Menu -->
        @endif

        <div class="@if(!$pos_layout) flex mt-[4.7rem] md:mt-0 @endif">
            
            @if(!$pos_layout)
                @include('layouts.partials.sidebar')
            @else
                @include('layouts.partials.header-pos')
            @endif
            
            @if(in_array($_SERVER['REMOTE_ADDR'], $whitelist))
                <input type="hidden" id="__is_localhost" value="true">
            @endif

            <!-- BEGIN: Content -->
            <div class="@if(!$pos_layout) content @endif">
                
                @if(!$pos_layout)
                    @include('layouts.partials.header')
                @endif

                <!-- Content Wrapper. Contains page content -->
                <div class="custom-main-content">
                    <!-- empty div for vuejs -->
                    <div id="app">
                        @yield('vue')
                    </div>
                    <!-- Add currency related field-->
                    <input type="hidden" id="__code" value="{{session('currency')['code']}}">
                    <input type="hidden" id="__symbol" value="{{session('currency')['symbol']}}">
                    <input type="hidden" id="__thousand" value="{{session('currency')['thousand_separator']}}">
                    <input type="hidden" id="__decimal" value="{{session('currency')['decimal_separator']}}">
                    <input type="hidden" id="__symbol_placement" value="{{session('business.currency_symbol_placement')}}">
                    <input type="hidden" id="__precision" value="{{session('business.currency_precision', 2)}}">
                    <input type="hidden" id="__quantity_precision" value="{{session('business.quantity_precision', 2)}}">
                    <!-- End of currency related field-->
                    @can('view_export_buttons')
                        <input type="hidden" id="view_export_buttons">
                    @endcan
                    @if(isMobile())
                        <input type="hidden" id="__is_mobile">
                    @endif
                    @if (session('status'))
                        <input type="hidden" id="status_span" data-status="{{ session('status.success') }}" data-msg="{{ session('status.msg') }}">
                    @endif
                    @yield('content')

                    <div class='scrolltop no-print'>
                        <div class='scroll icon'><i class="fas fa-angle-up"></i></div>
                    </div>

                    @if(config('constants.iraqi_selling_price_adjustment'))
                        <input type="hidden" id="iraqi_selling_price_adjustment">
                    @endif

                    <!-- This will be printed -->
                    <section class="invoice print_section" id="receipt_section">
                    </section>
                    
                </div>

            </div>
            <!-- END: Content -->
            @include('home.todays_profit_modal')

            <audio id="success-audio">
                <source src="{{ asset('/audio/success.ogg?v=' . $asset_v) }}" type="audio/ogg">
                <source src="{{ asset('/audio/success.mp3?v=' . $asset_v) }}" type="audio/mpeg">
            </audio>
            <audio id="error-audio">
                <source src="{{ asset('/audio/error.ogg?v=' . $asset_v) }}" type="audio/ogg">
                <source src="{{ asset('/audio/error.mp3?v=' . $asset_v) }}" type="audio/mpeg">
            </audio>
            <audio id="warning-audio">
                <source src="{{ asset('/audio/warning.ogg?v=' . $asset_v) }}" type="audio/ogg">
                <source src="{{ asset('/audio/warning.mp3?v=' . $asset_v) }}" type="audio/mpeg">
            </audio>
        </div>

        @if(!empty($__additional_html))
            {!! $__additional_html !!}
        @endif

        @include('layouts.partials.javascripts')

        <div class="modal fade view_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

        @if(!empty($__additional_views) && is_array($__additional_views))
            @foreach($__additional_views as $additional_view)
                @includeIf($additional_view)
            @endforeach
        @endif

        <!-- BEGIN: Dark Mode Switcher-->
        <!-- <div data-url="side-menu-dark-dashboard-overview-1.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
            <div class="mr-4 text-slate-600 dark:text-slate-200">Dark Mode</div>
            <div class="dark-mode-switcher__toggle border"></div>
        </div> -->
        <!-- END: Dark Mode Switcher-->
    </body>

</html>