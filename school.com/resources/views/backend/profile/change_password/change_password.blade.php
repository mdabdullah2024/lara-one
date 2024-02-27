@extends('backend.layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{$header_title}}</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
             <div class="row m-3">
              <div class="col-md-12">
                @include('backend.layouts.message')
                
              </div>
             </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- form start -->
              <form action="" method="post">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label>Old Password</label>
                    <input type="password" class="form-control form-control-sm" name="old_password" placeholder="Old Password" required  value="{{old('old_password')}}">
                  </div>
                  <div class="form-group">
                    <label>New Password</label>
                    <input type="password" class="form-control form-control-sm" name="new_password" placeholder="New Password" required value="{{old('new_password')}}">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection




