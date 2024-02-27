@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Notice Board</h1>
          </div>
         
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li><a class="btn btn-primary" href="{{url('/admin/communicate/notice_board/add')}}">Add New Notice Board</a></li>
            </ol>
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
            <h3 class="card-title">Search Notice Board</h3>
          </div>
          <form action="" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>Title</label>
                      <input type="text" name="title" class="form-control form-control-sm" value="{{Request::get('title')}}" placeholder="Title">
                    </div>
                  </div>
                  
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>Notice Date From</label>
                      <input type="date" name="notice_date_from" value="{{Request::get('notice_date_from')}}" id="GetDate" class="form-control form-control-sm" >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>Notice Date To</label>
                      <input type="date" name="notice_date_to" value="{{Request::get('notice_date_to')}}" id="GetDate" class="form-control form-control-sm" >
                    </div>
                  </div>
                  
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>Publish Date From</label>
                      <input type="date" name="publish_date_from" value="{{Request::get('publish_date_from')}}" id="GetDate" class="form-control form-control-sm" >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>Publish Date To</label>
                      <input type="date" name="publish_date_to" value="{{Request::get('publish_date_to')}}" id="GetDate" class="form-control form-control-sm" >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>Message To</label>
                      <select {{Request::get('message_to')}} class="form-control form-control-sm" name="message_to">
                        <option  value="">Select</option>
                        <option {{(!empty(Request::get('message_to')==2))?'selected':''}} value="2">Teacher</option>
                        <option {{(!empty(Request::get('message_to')==3))?'selected':''}} value="3">Student</option>
                        <option {{(!empty(Request::get('message_to')==4))?'selected':''}} value="4">Parent</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <button style="margin-top: 10px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 10px;" class="btn btn-success btn-sm" href="{{url('/admin/communicate/notice_board')}}"> Reset </a>
                    </div>
                </div>
              </div>
          </div>
        </form>
    </div>
            <div class="card" style="overflow:auto;">
              <div class="card-header">
                <h3 class="card-title">Notice Board List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped" >
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Notice Date</th>
                      <th>Publish Date</th>
                      <th>Message To</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($getRecord as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->title }}</td>
                        <td style="min-width: 165px;">{{ (!empty($value->notice_date))?date('d-m-Y',strtotime($value->notice_date)):'' }}</td>
                        <td style="min-width: 165px;">{{ (!empty($value->publish_date))?date('d-m-Y',strtotime($value->publish_date)):'' }}</td>
                        <td style="min-width: 165px;">
                          @foreach($value->getMessage as $message)
                            @if($message->message_to==2)
                              <div>Teacher</div>
                            @elseif($message->message_to==3)
                              <div>Student</div>
                            @elseif($message->message_to==4)
                              <div>Parent</div>
                            @endif

                          @endforeach
                        </td>
                        <td style="min-width: 165px;">{{ $value->created_by_name }} {{ $value->created_by_lastname }}</td>
                        <td style="min-width: 178px;">{{ date('d-m-Y h:i A',strtotime($value->created_at)) }}</td>
                        <td style="min-width: 165px;">
                        <a title="Edit" class="btn btn-primary" href="{{url('/admin/communicate/notice_board/edit/'.$value->id)}}">Edit</a>
                        <a title="Delete" class="btn btn-danger" href="{{url('/admin/communicate/notice_board/delete/'.$value->id)}}">Delete</a>
                      </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="100%">Record Not Found!</td>
                      </tr>
                    @endforelse
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




