@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Attendance Reports <span style="color: blue;">(Total:{{$getRecord->total()}})</span></h1>
          </div>
           
          <div class="col-md-12 mt-1">
            @include('backend.layouts.message')
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
      <div class="card m-3">
          <div class="card-header">
            <h3 class="card-title">Search Attendance Reports</h3>
          </div>
          <form action="" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Student ID</label>
                      <input type="text" name="student_id" class="form-control form-control-sm" value="{{Request::get('student_id')}}" placeholder="Student ID">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Student First Name</label>
                      <input type="text" name="student_name" class="form-control form-control-sm" value="{{Request::get('student_name')}}" placeholder="Student Name">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Student Last Name</label>
                      <input type="text" name="student_lastname" class="form-control form-control-sm" value="{{Request::get('student_lastname')}}" placeholder="Student Name">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Class</label>
                      <select class="form-control form-control-sm" name="class_id"  id="GetClass" >
                        <option value="">Select</option>
                        @foreach($getClass as $value)
                        <option {{ (Request::get('class_id')==$value->id?'selected':'') }} value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Attendance Types</label>
                      <select class="form-control form-control-sm " name="attendance_type" id="attendance_type">
                        <option value="">Select</option>
                        <option {{ (Request::get('attendance_type')==1?'selected':'') }} value="1">Present</option>
                        <option {{ (Request::get('attendance_type')==2?'selected':'') }} value="2">Late</option>
                        <option {{ (Request::get('attendance_type')==3?'selected':'') }} value="3">Absent</option>
                        <option {{ (Request::get('attendance_type')==4?'selected':'') }} value="4">Half Day</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Start Attendance Date</label>
                      <input type="date" name="start_attendance_date" value="{{Request::get('start_attendance_date')}}" id="GetDate" class="form-control form-control-sm" >
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>End Attendance Date</label>
                      <input type="date" name="end_attendance_date" value="{{Request::get('end_attendance_date')}}" id="GetDate" class="form-control form-control-sm" >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{url('/admin/attendance/reports')}}"> Reset </a>
                    </div>
                </div>
              </div>
          </div>
        </form>
    </div>



      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Student List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped" style="overflow: auto;">
                    <thead>
                      <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Class Name</th>
                        <th>Attendance</th>
                        <th>Attendance Date</th>
                        <th>Created By</th>
                        <th>Created Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($getRecord as $value)
                        <tr>
                          <td>{{ $value->id }}</td>
                          <td>{{ $value->student_name }} {{ $value->student_lastname }}</td>
                          <td>{{ $value->class_name }}</td>
                          <td>
                            @if($value->attendance_type==1)
                              Present
                            @elseif($value->attendance_type==2)
                            Late
                            @elseif($value->attendance_type==3)
                            Absent
                            @elseif($value->attendance_type==4)
                            Half Day
                            @endif
                          </td>
                          <td>{{ date('d-m-Y',strtotime($value->attendance_date)) }}</td>
                          <td>{{ $value->created_by_name }} {{ $value->created_by_lastname }}</td>
                          <td>{{ date('d-m-Y h:i A',strtotime($value->created_at)) }}</td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="100%">Record Not Found !</td>
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
@section('script')
<script type="text/javascript">

    $('.SaveAttendance').change(function(e){
      var student_id = $(this).attr('id');
      var attendance_type = $(this).val();
      var class_id = $('#GetClass').val();
      var attendance_date = $('#GetDate').val();
      
      $.ajax({
      type:'post',
      url:'{{ url('/admin/attendance/student/save') }}',
      data:{
        "_token":"{{ csrf_token() }}",
        student_id:student_id,
        attendance_type:attendance_type,
        class_id:class_id,
        attendance_date:attendance_date,
      },
      dataType: 'json',
      success: function(data){
        alert(data.message);
      }

    });
    });
</script>
@endsection




