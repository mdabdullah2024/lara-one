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
              <li class="breadcrumb-item"><a class="btn btn-primary" href="{{route('admin.parent.list')}}">Parent List</a></li>
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
              <form action="{{route('admin.parent.update',$getRecord->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>First Name <span style="color:red;">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="name" placeholder="First Name"  value="{{old('name',$getRecord->name)}}">
                            <div style="color:red;">{{$errors->first('name')}}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Last Name <span style="color:red;">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="last_name" placeholder="Last Name"  value="{{old('last_name',$getRecord->last_name)}}">
                            <div style="color:red;">{{$errors->first('last_name')}}</div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Gender <span style="color:red;">*</span></label>
                            <select class="form-control form-control-sm "  name="gender">
                              <option value="">Select Gender</option>
                              <option {{($getRecord->gender == 'Male')?'selected':''}} {{(old('gender')=='Male')?'selected':''}} value="Male">Male</option>
                              <option {{($getRecord->gender == 'Female')?'selected':''}} {{(old('gender')=='Female')?'selected':''}} value="Female">Female</option>
                              <option {{($getRecord->gender == 'Other')?'selected':''}} {{(old('gender')=='Other')?'selected':''}} value="Other">Other</option>
                            </select>
                            <div style="color:red;">{{$errors->first('gender')}}</div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Mobile Number <span style="color:red;">*</span></label>
                            <input  type="text" class="form-control form-control-sm" name="mobile_number" placeholder="mobile_number"  value="{{old('mobile_number',$getRecord->mobile_number)}}">
                            <div style="color:red;">{{$errors->first('mobile_number')}}</div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Occupation <span style="color:red;">*</span></label>
                            <input  type="text" class="form-control form-control-sm" name="occupation" placeholder="occupation"  value="{{old('occupation',$getRecord->occupation)}}">
                            <div style="color:red;">{{$errors->first('occupation')}}</div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status <span style="color:red;">*</span></label>
                            <select  class="form-control form-control-sm " name="status">
                              <option value="">Select Status</option>
                              <option {{($getRecord->gender == 0)?'selected':''}} {{(old('status')==0)?'selected':''}} value="0">Active</option>
                              <option {{($getRecord->gender == 1)?'selected':''}} {{(old('status')==1)?'selected':''}} value="1">Inactive</option>
                            </select>
                            <div style="color:red;">{{$errors->first('status')}}</div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Profile Picture</label>
                            <input id="image" type="file" class="form-control form-control-sm" name="profile_pic" placeholder="Profile Picture"  value="{{old('profile_pic')}}">
                            <img id="ImageShow" style="border:1px solid rgba(0, 0, 0,.2);width: 100px ; height: 110px;margin-top: 5px;"  src="{{$getRecord->getProfile()}}">
                            <div style="color:red;">{{$errors->first('profile_pic')}}</div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Address<span style="color:red;">*</span></label>
                            <textarea rows="6" cols=""  class="form-control form-control-sm" name="address" placeholder="Address" >{{old('address',$getRecord->address)}}</textarea>
                            <div style="color:red;">{{$errors->first('address')}}</div>

                        </div>
                    </div>
                  </div>

                  <hr>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email <span style="color:red;">*</span></label>
                            <input type="email" class="form-control form-control-sm" name="email" placeholder="Email"   value="{{old('email',$getRecord->email)}}">
                            <div style="color:red;">{{$errors->first('email')}}</div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password <span style="color:red;">*</span></label>
                            <input type="password" class="form-control form-control-sm" name="password" placeholder="Password"   value="{{old('password')}}">
                            <div style="color:red;">{{$errors->first('password')}}</div>

                        </div>
                    </div>
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




