@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Exam Schedule</h1>
          </div>
           
          <div class="col-md-12 mt-1">
            @include('backend.layouts.message')
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
      <div class="card m-3">
          <div class="card-header">
            <h3 class="card-title">Search Exam Schedule</h3>
          </div>
          <form action="" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Exam Name</label>
                      <select class="form-control form-control-sm" name="exam_id" required >
                        <option value="">Select</option>
                        @foreach($getExam as $exam)
                        <option {{ (Request::get('exam_id')==$exam->id?'selected':'') }} value="{{ $exam->id }}">{{ $exam->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Class</label>
                      <select class="form-control form-control-sm" name="class_id" required >
                        <option value="">Select</option>
                        @foreach($getClass as $value)
                        <option {{ (Request::get('class_id')==$value->id?'selected':'') }} value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{url('admin/examinations/exam_schedule/list')}}"> Reset </a>
                    </div>
                </div>
              </div>
          </div>
        </form>
    </div>
    @if(!empty($getRecord))
    <form action="{{url('admin/examinations/exam_schedule/list')}}" method="post">
      @csrf
      <input type="hidden" name="exam_id" class="form-control form-control-sm" value="{{Request::get('exam_id')}}">
      <input type="hidden" name="class_id" class="form-control form-control-sm" value="{{Request::get('class_id')}}">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Exam Schedule </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped" style="overflow: auto;">
                    <thead>
                      <tr>
                        <th>Subject</th>
                        <th>Exam Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Room Number</th>
                        <th>Full Marks</th>
                        <th>Passing Marks</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                      $i = 1;
                      @endphp
                     @foreach($getRecord as $value)
                     <tr>
                       <th>{{$value['subject_name']}}
                        <input type="hidden" value="{{$value['subject_id']}}" name="schedule[{{ $i }}][subject_id]">
                       </th>
                       <td>
                         <input value="{{$value['exam_date']}}" type="date" name="schedule[{{$i}}][exam_date]" class="form-control form-control-sm" >
                       </td>
                       <td>
                         <input type="time" value="{{$value['start_time']}}" name="schedule[{{$i}}][start_time]" class="form-control form-control-sm" >
                       </td>
                       <td>
                         <input type="time" name="schedule[{{$i}}][end_time]" value="{{$value['end_time']}}" class="form-control form-control-sm" >
                       </td>
                       <td>
                         <input type="text" name="schedule[{{$i}}][room_number]" class="form-control form-control-sm" value="{{$value['room_number']}}" placeholder="Room Number" >
                       </td>
                       <td>
                         <input type="text" name="schedule[{{$i}}][full_marks]"  class="form-control form-control-sm" placeholder="Full Marks" value="{{$value['full_marks']}}">
                       </td>
                       <td>
                         <input type="text" name="schedule[{{$i}}][passing_marks]" class="form-control form-control-sm" placeholder="Passing Marks" value="{{$value['passing_marks']}}">
                       </td>
                     </tr>
                     @php
                     $i++
                     @endphp
                     @endforeach
                    </tbody>
                  </table>
                  <div class="text-center p-2">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <!-- /.col -->
          </div>
        </div><!-- /.container-fluid -->
      </section>
    </form>
    @endif
    <!-- /.content -->
  </div>

@endsection




