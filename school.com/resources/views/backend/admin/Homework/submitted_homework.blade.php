@extends('backend.layouts.app')
@section('content')
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
              <li><a class="btn btn-primary" href="{{url('/admin/homework/homework')}}">Homework</a></li>
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
            <h3 class="card-title">Search Submitted Homework</h3>
          </div>
          <form action="" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">

                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>Student FirstName</label>
                      <input type="text" name="student_firstName" value="{{Request::get('student_firstName')}}" id="" class="form-control form-control-sm" placeholder="Student FirstName" >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>Student LastName</label>
                      <input type="text" name="student_lastName" value="{{Request::get('student_lastName')}}" id="" class="form-control form-control-sm" placeholder="Student LastName" >
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>From Created Date</label>
                      <input type="date" name="from_created_date" value="{{Request::get('from_created_date')}}" id="" class="form-control form-control-sm" >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>To Created Date</label>
                      <input type="date" name="to_created_date" value="{{Request::get('to_created_date')}}" id="" class="form-control form-control-sm" >
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{url('/admin/homework/submitted_homework/'.$homework_id)}}"> Reset </a>
                    </div>
                </div>
              </div>
          </div>
        </form>
    </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Submitted Homework List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Student Name</th>
                      <th>Document</th>
                      <th>Description</th>
                      <th>Created Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($getRecord as $value)
                    <tr>
                      <td>{{$value->id}}</td>
                      <td>{{$value->users_name}} {{$value->user_lastname}}</td>
                      <td>
                        @if(!empty($value->getDocument()))
                        <a title="Download Files" target="_blank" href="{{ $value->getDocument() }}" class="btn btn-primary">Download</a>
                        @endif
                      </td>
                      <td>{{$value->description}}</td>
                      <td>{{$value->created_at}}</td>
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




