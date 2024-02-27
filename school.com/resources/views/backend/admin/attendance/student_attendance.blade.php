@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Student Attendance</h1>
          </div>
           
          <div class="col-md-12 mt-1">
            @include('backend.layouts.message')
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
      <div class="card m-3">
          <div class="card-header">
            <h3 class="card-title">Search Class</h3>
          </div>
          <form action="" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Class</label>
                      <select class="form-control form-control-sm" name="class_id" required id="GetClass" >
                        <option value="">Select</option>
                        @foreach($getClass as $value)
                        <option {{ (Request::get('class_id')==$value->id?'selected':'') }} value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Attendance Date</label>
                      <input type="date" name="attendance_date" value="{{Request::get('attendance_date')}}" id="GetDate" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{url('/admin/attendance/student_attendance')}}"> Reset </a>
                    </div>
                </div>
              </div>
          </div>
        </form>
    </div>
    @if(!empty(Request::get('class_id')) && !empty(Request::get('attendance_date')))

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
                        <th>Attendance Type</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(!empty($getStudent) && !empty($getStudent->count()))
                      @foreach($getStudent as $value)
                      @php
                        $attendance_type = '';
                        $getAttendance = $value->getAttendance($value->id,Request::get('class_id'),Request::get('attendance_date'));
                        if(!empty($getAttendance->attendance_type))
                        {
                          $attendance_type = $getAttendance->attendance_type;
                        }
                      @endphp
                      <tr>
                        <td>{{$value->id}}</td>
                        <td>{{ $value->name}} {{ $value->last_name}}</td>
                        <td>
                          <label style="margin-right: 10px;">
                            <input type="radio" id="{{$value->id}} " class="SaveAttendance" name="attendance{{$value->id}}"  {{($attendance_type=='1')?'checked':''}}  value="1"> Present
                          </label>
                          <label style="margin-right: 10px;">
                            <input type="radio" id="{{$value->id}} " class="SaveAttendance" name="attendance{{$value->id}}" {{($attendance_type=='2')?'checked':''}}  value="2"> Late
                          </label>
                          <label style="margin-right: 10px;">
                            <input type="radio" id="{{$value->id}} " class="SaveAttendance" name="attendance{{$value->id}}"  {{($attendance_type=='3')?'checked':''}} value="3"> Absent
                          </label>
                          <label style="margin-right: 10px;">
                            <input type="radio" id="{{$value->id}} " class="SaveAttendance" name="attendance{{$value->id}}" {{($attendance_type=='4')?'checked':''}}  value="4"> Half Day
                          </label>
                        </td>
                      </tr>
                      @endforeach
                      @endif
                        
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
      @endif
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




