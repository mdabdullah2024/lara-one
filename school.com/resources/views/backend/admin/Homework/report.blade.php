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
            <h3 class="card-title">Search Homework Reports</h3>
          </div>
          <form action="" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Student FirstName</label>
                      <input type="text" name="first_name" class="form-control form-control-sm" value="{{Request::get('first_name')}}" placeholder="Student FirstName">
                    </div>
                  </div>

                   <div class="col-md-2">
                    <div class="form-group">
                      <label>Student LastName</label>
                      <input type="text" name="last_name" class="form-control form-control-sm" value="{{Request::get('last_name')}}" placeholder="Student LastName">
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Class</label>
                      <input type="text" name="class_name" class="form-control form-control-sm" value="{{Request::get('class_name')}}" placeholder="Class Name">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Subject</label>
                      <input type="text" name="subject_name" class="form-control form-control-sm" value="{{Request::get('subject_name')}}" placeholder="Subject Name">
                    </div>
                  </div>
                  
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>From Homework Date</label>
                      <input type="date" name="from_homework_date" value="{{Request::get('from_homework_date')}}" id="GetDate" class="form-control form-control-sm" >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>To Homework Date</label>
                      <input type="date" name="to_homework_date" value="{{Request::get('to_homework_date')}}" id="" class="form-control form-control-sm" >
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>From Submission Date</label>
                      <input type="date" name="from_submission_date" value="{{Request::get('from_submission_date')}}" id="" class="form-control form-control-sm" >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>To Submission Date</label>
                      <input type="date" name="to_submission_date" value="{{Request::get('to_submission_date')}}" id="" class="form-control form-control-sm" >
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

                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>From Submitted Created Date</label>
                      <input type="date" name="from_submitted_created_date" value="{{Request::get('from_submitted_created_date')}}" id="" class="form-control form-control-sm" >
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>To Submitted Created Date</label>
                      <input type="date" name="to_submitted_created_date" value="{{Request::get('to_submitted_created_date')}}" id="" class="form-control form-control-sm" >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{url('/admin/homework/homework_report')}}"> Reset </a>
                    </div>
                </div>
              </div>
          </div>
        </form>
    </div>
            <div class="card"  >
              <div class="card-header">
                <h3 class="card-title">Homework List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto;">
                <table class="table table-striped" >
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Student Name</th>
                      <th>Class</th>
                      <th>Subject</th>
                      <th>Homework Date</th>
                      <th>Submission Date</th>
                      <th>Document</th>
                      <th>Description</th>
                      <th>Created Date</th>
                      <th>Submitted Document</th>
                      <th>Submitted Description</th>
                      <th>Submitted Created Date</th>
                    </tr>
                  </thead>
                  <tbody>

                    @forelse($getRecord as $value)
                    <tr>
                      <td>{{ $value->id }}</td>
                      <td style="min-width:180px;">{{ $value->student_firstName }} {{ $value->student_lastName }}</td>
                      <td>{{ $value->class_name }}</td>
                      <td>{{ $value->subject_name }}</td>
                      <td>{{ date('d-m-Y',strtotime($value->getHomework->homework_date)) }}</td>
                      <td>{{ date('d-m-Y',strtotime($value->getHomework->submission_date)) }}</td>
                      <td>
                        @if(!empty($value->getHomework->getDocument()))
                        <a title="Download Files" target="_blank" href="{{ $value->getDocument() }}" class="btn btn-primary">Download</a>
                        @endif
                      </td>
                      <td>{!! $value->getHomework->description !!}</td>
                      <td>{{ date('d-m-Y h:i a',strtotime($value->getHomework->created_at)) }}</td>
                      <td>
                        @if(!empty($value->getDocument()))
                        <a title="Download Files" target="_blank" href="{{ $value->getDocument() }}" class="btn btn-primary">Download</a>
                        @endif
                      </td>
                      <td>{!! $value->description !!}</td>
                      <td>{{ date('d-m-Y h:i a',strtotime($value->created_at)) }}</td>
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




