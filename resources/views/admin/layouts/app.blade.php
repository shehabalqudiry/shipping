<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{asset('assets/admin')}}/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/admin')}}/images/favicon.png" type="image/x-icon">
    <title>لوحة التحكم | @yield('title', 'الرئيسية')</title>
    @include('admin.layouts.inc.styles')
    @livewireStyles
  </head>
  <body class="rtl {{ auth('admin')->user()->dark == 1 ? 'dark-only' : '' }}">
    <div class="loader-wrapper">
      <div class="loader-index"><span></span></div>
      <svg>
        <defs></defs>
        <filter id="goo">
          <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
          <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
        </filter>
      </svg>
    </div>
    <!-- tap on top starts-->
    <!-- <div class="tap-top"><i data-feather="chevrons-up"></i></div> -->
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      @include('admin.layouts.inc.header')
      <!-- Page Header Ends                              -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        @include('admin.layouts.inc.sidebar')
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h3>@yield('pageTitle')</h3>
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=""><i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item active">@yield('pageTitle')</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            @yield('content')
          </div>
          <!-- Container-fluid Ends-->
        </div>
        @include('admin.layouts.inc.footer')
      </div>
    </div>
    @include('admin.layouts.inc.scripts')
    @livewireScripts
  </body>
</html>
