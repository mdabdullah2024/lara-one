@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Attendance (<span style="color:blueviolet;">{{$getChild->name}} {{$getChild->last_name}}</span>) <span style="color: blue;">(Total:{{$getRecord->total()}})</span></h1>
          </div>
           
          <div class="col-md-12 mt-1">
            @include('backend.layouts.message')
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
      <div class="card m-3">
          <div class="card-header">
            <h3 class="card-title">Search My Attendance</h3>
          </div>
          <form action="" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label>Class</label>
                      <select class="form-control form-control-sm" name="class_id"  id="GetClass" >
                        <option value="">Select</option>
                        @foreach($getClass as $value)
                        <option {{ (Request::get('class_id')==$value->class_id?'selected':'') }} value="{{ $value->class_id }}">{{ $value->class_name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
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
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{url('/parent/my-children/my_attendance/'.$getChild->id)}}"> Reset </a>
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
                  <h3 class="card-title">My Attendance</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped" style="overflow: auto;">
                    <thead>
                      <tr>
                        <th>SL.</th>
                        <th>Class Name</th>
                        <th>Attendance Type</th>
                        <th>Attendance Date</th>
                        <th>Created Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(!empty($getRecord))
                      @foreach($getRecord as $key=>$value)
                        <tr>
                          <td>{{ $key+1 }}</td>
                          <td>{{ $value->class_name }}</td>
                          <td>
                            @if($value->attendance_type == 1)
                            Present
                            @elseif($value->attendance_type == 2)
                            Late
                            @elseif($value->attendance_type == 3)
                            Absent
                            @elseif($value->attendance_type == 4)
                            Half Day
                            @endif
                          </td>
                          <td>{{ date('d-m-Y',strtotime($value->attendance_date)) }}</td>
                          <td>{{ date('d-m-Y h:i A',strtotime($value->created_at)) }}</td>
                        </tr>
                      @endforeach
                      @else{
                        <tr>
                          <td colspan="100%">No Record Found !</td>
                        </tr>
                      }
                      @endif
                      <tr>
                        <td colspan="100%">Total Days Of Attendance:  {{ $getRecord->total()}} Days</td>
                      </tr>
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




