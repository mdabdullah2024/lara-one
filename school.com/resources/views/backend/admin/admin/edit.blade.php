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
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="btn btn-primary" href="{{route('admin.admin.list')}}">Admin List</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- form start -->
              <form action="{{route('admin.admin.udate',$getRecord->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{old('name',$getRecord->name)}}" name="name" placeholder="Name">
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" value="{{old('email',$getRecord->email)}}" name="email" placeholder="Email">
                    <font style="color:red;">{{$errors->first('email')}}</font>

                  </div>
                  <div class="form-group">
                            <label>Profile Picture</label>
                            <input id="image" type="file" class="form-control form-control-sm" name="profile_pic" placeholder="Profile Picture"  value="{{old('profile_pic',$getRecord->profile_pic)}}">
                            <div style="color:red;">{{$errors->first('profile_pic')}}</div>
                            @if(!empty($getRecord->getProfile()))
                            <img id="ImageShow" src="{{$getRecord->getProfile()}}" style="border:1px solid rgba(0, 0, 0,.2);width: 100px ; height: 110px;margin-top: 5px;">
                            @endif
                        </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="text" class="form-control" name="password" placeholder="Password">
                    <p>Do you want to change your password? So add new password.</p>
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




