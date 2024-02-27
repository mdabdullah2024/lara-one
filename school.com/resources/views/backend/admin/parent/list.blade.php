@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Parent List (Total: {{ $getRecord->total()}})</h1>
          </div>
         
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li><a class="btn btn-primary" href="{{route('admin.parent.add')}}">Add New Parent</a></li>
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
            <h3 class="card-title">Search Parent</h3>
          </div>
          <form action="" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Name</label>
                      <input type="text" class="form-control form-control-sm" name="name" value="{{Request::get('name')}}" placeholder="Name"  >
                    </div>
                  </div>
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="text" class="form-control form-control-sm" name="email" value="{{Request::get('email')}}" placeholder="Email"  >
                    </div>
                  </div>

                  <div class="col-md-3 ">
                    <div class="form-group">
                      <label>Mobile Number</label>
                      <input type="text" class="form-control form-control-sm" name="mobile_number" value="{{Request::get('mobile_number')}}" placeholder="Mobile"  >
                    </div>
                  </div>
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <label>Occupation</label>
                      <input type="text" class="form-control form-control-sm" name="occupation" value="{{Request::get('occupation')}}" placeholder="occupation"  >
                    </div>
                  </div>
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{route('admin.parent.list')}}"> Reset </a>
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
                <h3 class="card-title">Parent List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 " style=" overflow:auto;">
                <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Image</th>
                      <th>Email</th>
                      <th>Gender</th>
                      <th>Mobile Number</th>
                      <th>Occupation</th>
                      <th>Address</th>
                      <th>Status</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                    <tr>
                      <td style="min-width:20px;">{{$value->id}}</td>
                      <td style="min-width:187px;">{{$value->name}}{{$value->last_name}}</td>
                      <td>
                        <img src="{{$value->getProfile()}}" class="img-circle" style="width:100px;height: 100px;">
                      </td>
                      <td>{{$value->email}}</td>
                      <td>{{$value->gender}}</td>
                      <td style="min-width:187px;">{{$value->mobile_number}}</td>
                      <td>{{$value->occupation}}</td>
                      <td>{{$value->address}}</td>
                      <td>{{$value->status}}</td>
                      <td>{{date('m-d-Y H:i A',strtotime($value->created_at))}}</td>
                      <td style="min-width:187px;">
                        <a title="Edit" class="btn btn-primary" href="{{route('admin.parent.edit',$value->id)}}">Edit</a>
                        <a title="Delete" class="btn btn-danger" href="{{route('admin.parent.delete',$value->id)}}">Delete</a>
                        <a title="My Student" class="btn btn-primary" href="{{route('admin.parent.my_student',$value->id)}}">My Student</a>
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




