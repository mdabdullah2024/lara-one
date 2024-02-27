@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Teacher List (Total: {{ $getRecord->total()}})</h1>
          </div>
         
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li><a class="btn btn-primary" href="{{route('admin.teacher.add')}}">Add New Teacher</a></li>
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
            <h3 class="card-title">Search Teacher</h3>
          </div>
          <form action="" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>ID</label>
                      <input type="text" class="form-control form-control-sm" name="id" value="{{Request::get('id')}}" placeholder="ID"  >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>First Name</label>
                      <input type="text" class="form-control form-control-sm" name="name" value="{{Request::get('name')}}" placeholder="Frist Name"  >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label> Last Name</label>
                      <input type="text" class="form-control form-control-sm" name="last_name" value="{{Request::get('last_name')}}" placeholder="Last Name"  >
                    </div>
                  </div>
                  <div class="col-md-2 ">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="text" class="form-control form-control-sm" name="email" value="{{Request::get('email')}}" placeholder="Email"  >
                    </div>
                  </div>
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{route('admin.teacher.list')}}"> Reset </a>
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
                <h3 class="card-title">Teacher List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 " style="overflow: scroll;">
                <table  class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Image</th>
                      <th>Teacher Name</th>
                      <th>Email</th>
                      <th>Gender</th>
                      <th>Date Of Birth</th>
                      <th>Date Of Joining</th>
                      <th>Mobile</th>
                      <th>Marital Status</th>
                      <th>Present Address</th>
                      <th>Permanent Address</th>
                      <th>Qualification</th>
                      <th>Work Experience</th>
                      <th>Note</th>
                      <th>Status</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                    <tr>
                      <td>{{$value->id}}</td>
                      <td><img src="{{$value->getProfile()}}" class="img-circle" style="width:100px;height: 100px;"></td>

                      <td style="min-width: 130px;">{{$value->name}} {{$value->last_name}}</td>
                      <td>{{$value->email}}</td>
                      <td>{{$value->gender}}</td>
                      <td style="min-width: 107px;">
                        <?php if (!empty($value->date_of_birth)): ?>
                          {{date('d-m-Y',strtotime($value->date_of_birth))}}
                        <?php endif ?>
                      </td>
                      <td style="min-width: 107px;">
                        <?php if (!empty($value->admission_date)): ?>
                          {{date('d-m-Y',strtotime($value->admission_date))}}
                        <?php endif ?>
                      </td>
                      <td>{{$value->mobile_number}}</td>
                      <td>{{$value->marital_status}}</td>
                      <td>{{$value->address}}</td>
                      <td>{{$value->permanent_address}}</td>
                      <td>{{$value->qualification}}</td>
                      <td>{{$value->work_experience}}</td>
                      <td>{{$value->note}}</td>
                      <td>
                       {{($value->status == 0?'Active':'Inactive')}}
                      </td>
                      <td style="min-width: 107px;">{{date('m-d-Y H:i A',strtotime($value->created_at))}}</td>
                      <td style="min-width: 167px;">
                        <a title="Edit" class="btn btn-primary" href="{{route('admin.teacher.edit',$value->id)}}">Edit</a>
                        <a title="Delete" class="btn btn-danger" href="{{route('admin.teacher.delete',$value->id)}}">Delete</a>
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




