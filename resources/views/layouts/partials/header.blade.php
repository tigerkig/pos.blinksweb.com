@inject('request', 'Illuminate\Http\Request')

  <!-- BEGIN: Top Bar -->
  <div class="top-bar main-header" style="justify-content: end;">
    <nav class="-intro-x sm:flex" role="navigation">

      @if(Module::has('Superadmin'))
        @includeIf('superadmin::layouts.partials.active_subscription')
      @endif

      @if(!empty(session('previous_user_id')) && !empty(session('previous_username')))
          <a href="{{route('sign-in-as-user', session('previous_user_id'))}}" class="btn btn-flat btn-danger m-8 btn-sm mt-10"><i class="fas fa-undo"></i> @lang('lang_v1.back_to_username', ['username' => session('previous_username')] )</a>
      @endif

      <div class="navbar-custom-menu">

        @if(Module::has('Essentials'))
          @includeIf('essentials::layouts.partials.header_part')
        @endif

        <div class="btn-group">
          <button id="header_shortcut_dropdown" type="button" class="btn btn-success dropdown-toggle btn-flat pull-left m-8 btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-plus-circle fa-lg"></i>
          </button>
          <ul class="dropdown-menu">
            @if(config('app.env') != 'demo')
              <li><a href="{{route('calendar')}}">
                  <i class="fas fa-calendar-alt" aria-hidden="true"></i> @lang('lang_v1.calendar')
              </a></li>
            @endif
            @if(Module::has('Essentials'))
              <li><a href="#" class="btn-modal" data-href="{{action('\Modules\Essentials\Http\Controllers\ToDoController@create')}}" data-container="#task_modal">
                  <i class="fas fa-clipboard-check" aria-hidden="true"></i> @lang( 'essentials::lang.add_to_do' )
              </a></li>
            @endif
            @if(auth()->user()->hasRole('Admin#' . auth()->user()->business_id))
              <li><a id="start_tour" href="#">
                  <i class="fas fa-question-circle" aria-hidden="true"></i> @lang('lang_v1.application_tour')
              </a></li>
            @endif
          </ul>
        </div>
        
        
        @if($request->segment(1) == 'pos')
          @can('view_cash_register')
          <button type="button" id="register_details" title="{{ __('cash_register.register_details') }}" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left m-8 btn-sm btn-modal" data-container=".register_details_modal" 
          data-href="{{ action('CashRegisterController@getRegisterDetails')}}">
            <strong><i class="fa fa-briefcase fa-lg" aria-hidden="true"></i></strong>
          </button>
          @endcan
          @can('close_cash_register')
          <button type="button" id="close_register" title="{{ __('cash_register.close_register') }}" data-toggle="tooltip" data-placement="bottom" class="btn btn-danger btn-flat pull-left m-8 btn-sm mt-10 btn-modal" data-container=".close_register_modal" 
          data-href="{{ action('CashRegisterController@getCloseRegister')}}">
            <strong><i class="fa fa-window-close fa-lg"></i></strong>
          </button>
          @endcan
        @endif

        @if(in_array('pos_sale', $enabled_modules))
          @can('sell.create')
            <a href="{{action('SellPosController@create')}}" title="@lang('sale.pos_sale')" data-toggle="tooltip" data-placement="bottom" class="btn btn-flat pull-left m-8 btn-sm btn-success">
              <strong><i class="fa fa-th-large"></i> &nbsp; @lang('sale.pos_sale')</strong>
            </a>
          @endcan
        @endif

        @if(Module::has('Repair'))
          @includeIf('repair::layouts.partials.header')
        @endif

        @can('profit_loss_report.view')
          <button type="button" id="view_todays_profit" title="{{ __('home.todays_profit') }}" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left m-8 btn-sm">
            <strong><i class="fas fa-money-bill-alt fa-lg"></i></strong>
          </button>
        @endcan

        <div class="m-8 pull-left hidden-xs" style="color: #2196f3;"><strong>{{ @format_date('now') }}</strong></div>

        <ul class="nav navbar-nav">
          @include('layouts.partials.header-notifications')
        </ul>
      </div>
    </nav>

    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8">
        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false" data-tw-toggle="dropdown">
            @if(!empty($profile_photo))
              <img src="{{$profile_photo->display_url}}" alt="Has User Image">
            @else
              <img alt="no user image" src="{{ asset('style/images/profile-5.jpg') }}">
            @endif
        </div>
        <div class="dropdown-menu-custom w-56">
            <ul class="dropdown-content bg-primary text-white">
                <li class="p-2">
                    <div class="font-medium">{{ Auth::User()->first_name }} {{ Auth::User()->last_name }}</div>
                    <!-- <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">Software Engineer</div> -->
                </li>
                <li>
                    <hr class="dropdown-divider border-white/[0.08]">
                </li>
                <li>
                    <a href="{{action('UserController@getProfile')}}" class="dropdown-item hover:bg-white/5"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> @lang('lang_v1.profile') </a>
                </li>
                <li>
                    <a href="{{action('Auth\LoginController@logout')}}" class="dropdown-item hover:bg-white/5"> <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> @lang('lang_v1.sign_out') </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Account Menu -->
  </div>
  <!-- END: Top Bar -->