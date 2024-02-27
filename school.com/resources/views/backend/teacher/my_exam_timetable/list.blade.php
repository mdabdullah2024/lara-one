@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Exam Timetable</h1>
          </div>
          <div class="col-md-12 mt-1">
            @include('backend.layouts.message')
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @foreach($getRecord as $value)
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <h4 style="margin-left: 5px;"> Class:<span style="color:blue;"> {{$value['class_name']}}</span></h4>
            <div class="card">
              <div class="card-header">
                @foreach($value['exam'] as $exam)
                <h3 class="card-title">Exam Name: <span style="font-weight: bold;">{{ $exam['exam_name'] }}</span></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                  <table class="table table-striped" width="100%">
                    <thead> 
                        <tr>
                          <th>Subject</th>
                          <th>Day</th>
                          <th>Exam Date</th>
                          <th>Start Time</th>
                          <th>End Time</th>
                          <th>Room No</th>
                          <th>Full Marks</th>
                          <th>Passing Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach($exam['subject'] as $valueS)
                        <tr>
                          <th>{{ $valueS['subject_name']}}</th>
                          <td>{{ date('l',strtotime($valueS['exam_date'])) }}</td>
                          <td>{{ date('d-m-Y',strtotime($valueS['exam_date'])) }}</td>
                          <td>{{date('h:i a',strtotime($valueS['start_time']))}}</td>
                          <td>{{date('h:i a',strtotime($valueS['end_time']))}}</td>
                          <td>{{$valueS['room_number']}}</td>
                          <td>{{$valueS['full_marks']}}</td>
                          <td>{{$valueS['passing_marks']}}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
              @endforeach
              <!-- /.card-body -->
            </div>

          </div>

          <!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    @endforeach
  </div>

@endsection


