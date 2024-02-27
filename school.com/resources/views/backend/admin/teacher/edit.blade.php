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
              <li class="breadcrumb-item"><a class="btn btn-primary" href="{{route('admin.teacher.list')}}">Teacher List</a></li>
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
              <form action="{{route('admin.teacher.update',$getRecord->id)}}" method="post" enctype="multipart/form-data">
                @csrf
              <div class="card">
                <div class="card-header">
                  <h4>Teacher Registration Edit</h4>
                </div>
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
                            <label>Date Of Birth <span style="color:red;">*</span></label>
                            <input type="date" class="form-control form-control-sm" name="date_of_birth" placeholder="Date Of Birth"  value="{{old('date_of_birth',$getRecord->date_of_birth)}}">
                            <div style="color:red;">{{$errors->first('date_of_birth')}}</div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Joining Date<span style="color:red;">*</span></label>
                            <input type="date" class="form-control form-control-sm" name="admission_date" placeholder="Date Of Birth"  value="{{old('admission_date',$getRecord->admission_date)}}">
                            <div style="color:red;">{{$errors->first('admission_date')}}</div>

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
                            <label>Marital Status <span style="color:red;">*</span></label>
                            <input  type="text" class="form-control form-control-sm" name="marital_status" placeholder="marital_status"  value="{{old('marital_status',$getRecord->mobile_number)}}">
                            <div style="color:red;">{{$errors->first('marital_status')}}</div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Profile Picture</label>
                            <input id="image" type="file" class="form-control form-control-sm" name="profile_pic" placeholder="Profile Picture"  value="{{old('profile_pic',$getRecord->profile_pic)}}">
                            <img id="ImageShow" style="border:1px solid rgba(0, 0, 0,.2);width: 100px ; height: 110px;margin-top: 5px;"  src="{{$getRecord->getProfile()}}">
                            <div style="color:red;">{{$errors->first('profile_pic')}}</div>

                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Present Address<span style="color:red;">*</span></label>
                            <textarea rows="6" cols=""  class="form-control form-control-sm" name="address" placeholder="Present Address" >{{old('address',$getRecord->address)}}</textarea>
                            <div style="color:red;">{{$errors->first('address')}}</div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Permanent Address<span style="color:red;">*</span></label>
                            <textarea rows="6" cols=""  class="form-control form-control-sm" name="permanent_address" placeholder="Permanent Address" >{{old('permanent_address',$getRecord->permanent_address)}}</textarea>
                            <div style="color:red;">{{$errors->first('permanent_address')}}</div>

                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Qualification<span style="color:red;">*</span></label>
                            <textarea rows="6" cols=""  class="form-control form-control-sm" name="qualification" placeholder="Qualification" >{{old('qualification',$getRecord->qualification)}}</textarea>
                            <div style="color:red;">{{$errors->first('qualification')}}</div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Work Experience<span style="color:red;">*</span></label>
                            <textarea rows="6" cols=""  class="form-control form-control-sm" name="work_experience" placeholder="Work Experience" >{{old('work_experience',$getRecord->work_experience)}}</textarea>
                            <div style="color:red;">{{$errors->first('work_experience')}}</div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Note<span style="color:red;">*</span></label>
                            <textarea rows="6" cols=""  class="form-control form-control-sm" name="note" placeholder="Note" >{{old('note',$getRecord->note)}}</textarea>
                            <div style="color:red;">{{$errors->first('note')}}</div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status <span style="color:red;">*</span></label>
                            <select  class="form-control form-control-sm " name="status">
                              <option value="">Select Status</option>
                              <option {{($getRecord->status == 0)?'selected':''}} {{(old('status')==0)?'selected':''}} value="0">Active</option>
                              <option {{($getRecord->status == 1)?'selected':''}} {{(old('status')==1)?'selected':''}} value="1">Inactive</option>
                            </select>
                            <div style="color:red;">{{$errors->first('status')}}</div>

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
              </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary btn-sm">Update</button>
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




