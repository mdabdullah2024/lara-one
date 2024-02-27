@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Student List (Total: {{ $getRecord->total()}})</h1>
          </div>
         
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li><a class="btn btn-primary" href="{{route('admin.student.add')}}">Add New Student</a></li>
            </ol>
          </div>
           
          <div class="col-md-12 mt-1">
            @include('backend.layouts.message')
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
      <div class="card m-3">
          <div class="card-header">
            <h3 class="card-title">Search Student</h3>
          </div>
          <form action="" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>Name</label>
                      <input type="text" class="form-control form-control-sm" name="name" value="{{Request::get('name')}}" placeholder="Name"  >
                    </div>
                  </div>
                  <div class="col-md-2 ">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="text" class="form-control form-control-sm" name="email" value="{{Request::get('email')}}" placeholder="Email"  >
                    </div>
                  </div>

                  <div class="col-md-2 ">
                    <div class="form-group">
                      <label>Admission No.</label>
                      <input type="text" class="form-control form-control-sm" name="admission_number" value="{{Request::get('admission_number')}}" placeholder="Admission Number"  >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Class</label>
                      <select  class="form-control form-control-sm" name="class_id"  placeholder="date"  >
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                        <option {{(Request::get('class_id')==$class->id)?'selected':''}} value="{{$class->id}}">{{$class->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-2 ">
                    <div class="form-group">
                      <label>Roll Number</label>
                      <input type="text" class="form-control form-control-sm" name="roll_number" value="{{Request::get('roll_number')}}" placeholder="Roll Number"  >
                    </div>
                  </div>
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{route('admin.student.list')}}"> Reset </a>
                    </div>
                </div>
              </div>
          </div>
        </form>
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Student List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 " style="overflow: scroll;">
                <table  class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Student Name</th>
                      <th>Parent Name</th>
                      <th>Image</th>
                      <th>Email</th>
                      <th title="Admission Number">Ad No</th>
                      <th title="Admission Date">Ad.Date</th>
                      <th>DOB</th>
                      <th>Mobile</th>
                      <th>Roll</th>
                      <th>Class</th> 
                      <th>Gender</th>
                      <th>Religion</th>
                      <th>Height</th>
                      <th>Weight</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                    <tr>
                      <td>{{$value->id}}</td>
                      <td style="min-width: 130px;">{{$value->name}} {{$value->last_name}}</td>
                      <td style="min-width: 130px;">{{$value->parent_name}} {{$value->parent_lastname}}</td>
                      <td><img src="{{$value->getProfile()}}" class="img-circle" style="width:100px;height: 100px;"></td>
                      <td>{{$value->email}}</td>
                      <td>{{$value->admission_number}}</td>
                      <td style="min-width: 107px;">
                        <?php if (!empty($value->admission_date)): ?>
                          {{date('d-m-Y',strtotime($value->admission_date))}}
                        <?php endif ?>
                      </td>
                      <td style="min-width: 107px;">
                        <?php if (!empty($value->date_of_birth)): ?>
                          {{date('d-m-Y',strtotime($value->date_of_birth))}}
                        <?php endif ?>
                      </td>
                      <td>{{$value->mobile_number}}</td>
                      <td>{{$value->roll_number}}</td>
                      <td>{{$value->class_id_name}}</td>
                      <td>{{$value->gender}}</td>
                      <td>{{$value->religion}}</td>
                      <td>{{$value->height}}</td>
                      <td>{{$value->weight}}</td>
                      <td style="min-width: 107px;">{{date('m-d-Y H:i A',strtotime($value->created_at))}}</td>
                      <td style="min-width: 167px;">
                        <a title="Edit" class="btn btn-primary" href="{{route('admin.student.edit',$value->id)}}">Edit</a>
                        <a title="Delete" class="btn btn-danger" href="{{route('admin.student.delete',$value->id)}}">Delete</a>
                        <a title="Chat" class="btn btn-success" href="{{url('chat?receiver_id='.base64_encode($value->id))}}">Send Message</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <div style=" margin-top: 10px; text-align: center; float:right;">{!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}</div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection




