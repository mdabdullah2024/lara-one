@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Subject List</h1>
          </div>
         
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li><a class="btn btn-primary" href="{{route('admin.subject.add')}}">Add New Subject</a></li>
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
            <h3 class="card-title">Search Subject</h3>
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
                  <div class="col-md-3">
                    <div class="form-group ">
                      <div class="form-group">
                        <label>Subject Type</label>
                          <select class="form-control form-control-sm" name="type">
                              <option value="">Select Subject Type</option>
                              <option {{(Request::get('type')=='Theory')?'selected':''}} value="Theory">Theory</option>
                              <option {{(Request::get('type')=='Practical')?'selected':''}} value="Practical">Practical</option>
                        </select>
                   </div>
                    </div>
                  </div>
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <label>Date</label>
                      <input type="date" class="form-control form-control-sm" name="date" value="{{Request::get('date')}}" placeholder="date"  >
                    </div>
                  </div>
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{route('admin.subject.list')}}"> Reset </a>
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
                <h3 class="card-title">Subject List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Type</th>
                      <th>Status</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($getRecord as $value)
                   <tr>
                     <td>{{$value->id}}</td>
                     <td>{{$value->name}}</td>
                     <td>{{$value->type}}</td>
                     <td>
                       @if( $value->status == 0)
                       Active
                       @else
                       Inactive
                       @endif
                     </td>
                     <td>{{$value->created_by_name}}</td>
                     <td>{{date('d-m-Y h:i A',strtotime($value->created_at))}}</td>
                     <td>
                       <a title="Edit" class="btn btn-primary btn-sm" href="{{route('admin.subject.edit',$value->id)}}">Edit</a>
                       <a title="delete" class="btn btn-danger btn-sm" href="{{route('admin.subject.delete',$value->id)}}">delete</a>
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




