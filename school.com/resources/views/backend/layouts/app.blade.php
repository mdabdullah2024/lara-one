<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{!empty($header_title)?$header_title:''}}-School</title>
    @include('backend.layouts.style')
    @yield('style')
  @php
    $getSettingsRecord = App\Models\SettingsModel::getSingle();
  @endphp
  <link rel="icon" type="image/jpg" href="{{ $getSettingsRecord->Fevicon() }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  @include('backend.layouts.header')
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('')}}" class="brand-link">
      <img src="{{ $getSettingsRecord->getLogo() }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">School.com</span>
    </a>

    <!-- Sidebar -->
    @include('backend.layouts.sidebar')
    <!-- /.sidebar -->
  </aside>
  <!-- /.content-wrapper -->
  @yield('content')
  <!-- /.content-wrapper -->
 @include('backend.layouts.footer')

</div>
<!-- ./wrapper -->


  @include('backend.layouts.script')
  @yield('script')
</body>
</html>
