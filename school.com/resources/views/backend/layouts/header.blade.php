
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
@php
  $getUserChatCount = App\Models\ChatModel::getUserChatCount();
@endphp
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item ">
        <a class="nav-link"  href="{{ url('chat') }}">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger">
          {{ !empty($getUserChatCount)?$getUserChatCount:' ' }}
        </span>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->