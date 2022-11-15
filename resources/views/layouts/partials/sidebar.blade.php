
<!-- BEGIN: Side Menu -->
<nav class="side-nav">
  <a href="" class="intro-x flex items-center pl-5 pt-4">
      <img alt="Midone - HTML Admin Template" class="w-6" src="{{ asset('style/images/logo.svg') }}">
      <span class="hidden xl:block text-white text-lg ml-3"> Blinks Web </span> 
  </a>
  <div class="side-nav__devider my-6"></div>
  
  {!! Menu::render('admin-sidebar-menu', 'adminltecustom'); !!}

</nav>