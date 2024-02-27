@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Parent Student List <span><small>({{$getParent->name}} {{$getParent->last_name}})</small></span></h1>
          </div>
           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li><a class="btn btn-primary" href="{{route('admin.parent.list')}}">Parent List</a></li>
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
            <h3 class="card-title">Search Parent Student</h3>
          </div>
          <form action="" method="get" >
            <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Student ID</label>
                      <input type="text" class="form-control form-control-sm" name="id" value="{{Request::get('id')}}" placeholder="Student ID"  >
                    </div>
                  </div>
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <label>First Name</label>
                      <input type="text" class="form-control form-control-sm" name="name" value="{{Request::get('name')}}" placeholder="Frist Name"  >
                    </div>
                  </div>
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <label>Last Name</label>
                      <input type="text" class="form-control form-control-sm" name="last_name" value="{{Request::get('last_name')}}" placeholder="Last Name"  >
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
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{route('admin.parent.my_student',$parent_id)}}"> Reset </a>
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
            @if(!empty($getSearchStudent))
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Student List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 " style=" overflow:auto;">
                <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Image</th>
                      <th>Student Name</th>
                      <th>Email</th>
                      <th>Parent Name</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($getSearchStudent as $value)
                    <tr>
                      <td>{{$value->id}}</td>
                      <td><img src="{{$value->getProfile()}}" class="img-circle" style="width:100px;height: 100px;"></td>
                      <td style="min-width: 130px;">{{$value->name}} {{$value->last_name}}</td>

                      <td>{{$value->email}}</td>
                      <td>{{$value->parent_name}}</td>
                      <td style="min-width: 107px;">{{date('m-d-Y H:i A',strtotime($value->created_at))}}</td>
                      <td style="min-width: 167px;">
                        <a title="Assign Student to Parent" class="btn btn-primary" href="{{url('/admin/parent/assing-student-to-parent/'.$value->id.'/'.$parent_id)}}">Assign Student to Parent</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            @endif
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Parent Student List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 " style=" overflow:auto;">
                <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Image</th>
                      <th>Student Name</th>
                      <th>Email</th>
                      <th>Parent Name</th>
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
                      <td>{{$value->parent_name}}</td>
                      <td style="min-width: 107px;">{{date('m-d-Y H:i A',strtotime($value->created_at))}}</td>
                      <td style="min-width: 167px;">
                        <a title="Assign Student to Parent" class="btn btn-danger" href="{{url('/admin/parent/assing-student-to-parent-delete/'.$value->id)}}">Assign Parent Delete</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
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




