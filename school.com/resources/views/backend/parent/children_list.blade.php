@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Parent Children List </h1>
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
                <h3 class="card-title">Parent Children List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 " style=" overflow:auto;">
                <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Child Name</th>
                      <th>Image</th>
                      <th>Email</th>
                      <th title="Admission Number">Admission Number</th>
                      <th title="Admission Date">Admission Date</th>
                      <th>Date Of Birth</th>
                      <th>Mobile</th>
                      <th>Roll</th>
                      <th>Class</th> 
                      <th>Gender</th>
                      <th>Religion</th>
                      <th>Height</th>
                      <th>Weight</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($getRecord as $value)
                    <tr>
                      <td>{{$value->id}}</td>
                      <td style="min-width: 130px;">{{$value->name}} {{$value->last_name}}</td>
                      <td><img src="{{$value->getProfile()}}" class="img-circle" style="width:100px;height: 100px;"></td>
                      <td>{{$value->email}}</td>
                      <td>{{$value->admission_number}}</td>
                      <td style="min-width: 107px;">
                        <?php if (!empty($value->admission_date)): ?>
                          {{date('d-m-Y',strtotime($value->admission_date))}}
                        <?php endif ?>
                      </td>
                      <td style="min-width: 107px;">
                        <?php if (!empty($value->date_of_birth)): ?>
                          {{date('d-m-Y',strtotime($value->date_of_birth))}}
                        <?php endif ?>
                      </td>
                      <td>{{$value->mobile_number}}</td>
                      <td>{{$value->roll_number}}</td>
                      <td>{{$value->class_id_name}}</td>
                      <td>{{$value->gender}}</td>
                      <td>{{$value->religion}}</td>
                      <td>{{$value->height}}</td>
                      <td>{{$value->weight}}</td>
                      <td style="min-width: 107px;">{{date('m-d-Y H:i A',strtotime($value->created_at))}}</td>
                      <td style="min-width:300px;">
                        <a style="margin-bottom: 10px;" title="Subject" class="btn btn-success btn-sm" href="{{route('parent.children.subject.list',$value->id)}}">Subject</a>
                        <a style="margin-bottom: 10px;" title="Exam Timetable" class="btn btn-primary btn-sm" href="{{url('/parent/my-children/exam-timetable/'.$value->id)}}">Exam Timetable</a>
                        <a style="margin-bottom: 10px;" title="Exam Result" class="btn btn-warning btn-sm" href="{{url('/parent/my-children/exam_result/'.$value->id)}}">Exam Result</a>
                        <a style="margin-bottom: 10px;" title="My Calendar" class="btn btn-secondary btn-sm" href="{{url('/parent/my-children/my-calendar/'.$value->id)}}">Calendar</a>
                        <a style="margin-bottom: 10px;" title="My Attendance" class="btn btn-dark btn-sm" href="{{url('/parent/my-children/my_attendance/'.$value->id)}}">Attendance</a>
                        <a style="margin-bottom: 10px;" title="My Child Homework" class="btn btn-success btn-sm" href="{{url('/parent/my-children/homework/'.$value->id)}}">Homework</a>
                        <a style="margin-bottom: 10px;" title="My Child Submitted Homework" class="btn btn-light btn-sm" href="{{url('/parent/my-children/homework/submitted/'.$value->id)}}">Submitted Homework</a>
                        <a style="margin-bottom: 10px;" title="My Child Fee Collection" class="btn btn-success btn-sm" href="{{url('/parent/my-children/fees_collection/'.$value->id)}}">Fees Collection</a>
                        <a title="Delete" class="btn btn-success btn-sm" href="{{url('chat?receiver_id='.base64_encode($value->id))}}">Send Message</a>

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




