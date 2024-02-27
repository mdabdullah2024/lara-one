@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Student List</h1>
          </div>
           
          <div class="col-md-12 mt-1">
            @include('backend.layouts.message')
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
     
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Student List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 " style="overflow: scroll;">
                <table  class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Student Name</th>
                      <th>Image</th>
                      <th>Email</th>
                      
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
                      
                      <td><img src="{{$value->getProfile()}}" class="img-circle" style="width:100px;height: 100px;"></td>
                      <td>{{$value->email}}</td>
                      
                      <td>{{$value->mobile_number}}</td>
                      <td>{{$value->roll_number}}</td>
                      <td>{{$value->class_id_name}}</td>
                      <td>{{$value->gender}}</td>
                      <td>{{$value->religion}}</td>
                      <td>{{$value->height}}</td>
                      <td>{{$value->weight}}</td>
                      <td style="min-width: 107px;">{{date('m-d-Y H:i A',strtotime($value->created_at))}}</td>
                      <td>
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




