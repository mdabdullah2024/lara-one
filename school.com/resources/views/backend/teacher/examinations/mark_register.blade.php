@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Exam Mark Register</h1>
          </div>
           
          <div class="col-md-12 mt-1">
            @include('backend.layouts.message')
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
      <div class="card m-3">
          <div class="card-header">
            <h3 class="card-title">Search Exam Mark Register</h3>
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
                        <option {{ (Request::get('exam_id')==$exam->exam_id?'selected':'') }} value="{{ $exam->exam_id }}">{{ $exam->exam_name }}</option>
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
                        <option {{ (Request::get('class_id')==$value->class_id?'selected':'') }} value="{{ $value->class_id }}">{{ $value->class_name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{url('/teacher/marks_register')}}"> Reset </a>
                    </div>
                </div>
              </div>
          </div>
        </form>
    </div>
    @if(!empty($getSubject) && !empty($getSubject->count()))

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Mark Register</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped" style="overflow: auto;">
                    <thead>
                      <tr>

                        <th>Student Name</th>
                        @foreach($getSubject as $subject)
                        <th>
                          {{$subject->subject_name}}<br>
                          {{$subject->subject_type}} : {{$subject->passing_marks}}/{{$subject->full_marks}}
                        </th>
                        @endforeach
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(!empty($getStudent) && !empty($getStudent->count()))
                       @foreach( $getStudent as $student)
                      <form method="post" action="" class="MarksData">
                        @csrf
                        <input type="hidden" name="student_id" value="{{$student->id}}">
                        <input type="hidden" name="exam_id"  value="{{ Request::get('exam_id')}}">
                        <input type="hidden" name="class_id" value="{{ Request::get('class_id')}}">
                       
                        <tr>
                            <td style="text-align: center;vertical-align: middle;min-width: 169px;">{{ $student->name }} {{ $student->last_name }}
                            </td>
                            @php

                            $pass_fail_vali = 0;
                            $i = 1;
                            $total_student_marks = 0;
                            $total_passing_marks = 0;
                            $total_full_marks = 0;
                            $total_marks = 0;
                            @endphp

                            @foreach($getSubject as $subject)

                            @php
                            $getMark = $subject->getMark($student->id,Request::get('exam_id'),Request::get('class_id'),$subject->subject_id);
                            if(!empty($getMark->class_work)){
                            $total_marks = $getMark->class_work + $getMark->home_work + $getMark->test_work + $getMark->exam;
                            }
                            $total_student_marks = $total_student_marks + $total_marks;
                            $total_full_marks = $total_full_marks + $subject->full_marks;

                            $total_passing_marks = $total_passing_marks + $subject->passing_marks;

                            @endphp
                            <td>
                               <input type="hidden" name="mark[{{$i}}][full_marks]" value="{{  $subject->full_marks }}" class="form-control form-control-sm">
                               <input type="hidden" name="mark[{{$i}}][passing_marks]" value="{{  $subject->passing_marks }}" class="form-control form-control-sm">
                               <input type="hidden" name="mark[{{$i}}][id]" value="{{  $subject->id }}" class="form-control form-control-sm">
                               <input type="hidden" name="mark[{{$i}}][subject_id]" value="{{  $subject->subject_id }}" class="form-control form-control-sm">
                              <div>
                                <label>Class Work</label>
                                <input type="text" name="mark[{{ $i }}][class_work]" value="{{ (!empty($getMark->class_work))?$getMark->class_work:'' }}" class="form-control form-control-sm" id="class_work_{{$student->id}}{{$subject->id}}">
                              </div>
                              <div>
                                <label>Home Work</label>
                                <input type="text" name="mark[{{ $i }}][home_work]"  class="form-control form-control-sm" value="{{ (!empty($getMark->home_work))?$getMark->home_work:'' }}" id="home_work_{{$student->id}}{{$subject->id}}">
                              </div>
                              <div>
                                <label>Test Work</label>
                                <input type="text" name="mark[{{ $i }}][test_work]"  class="form-control form-control-sm" value="{{ (!empty($getMark->test_work))?$getMark->test_work:'' }}" id="test_work_{{$student->id}}{{$subject->id}}">
                              </div>
                              <div>
                                <label>Exam </label>
                                <input type="text" name="mark[{{ $i }}][exam]"  class="form-control form-control-sm" value="{{ (!empty($getMark->exam))?$getMark->exam:'' }}" id="exam_{{$student->id}}{{$subject->id}}">
                              </div>
                              <div style="margin-top:10px;">
                                <button type="button" class="btn btn-primary btn-sm saveSingleSubject" id="{{$student->id}}" data-subject="{{$subject->id}}" data-exam="{{ Request::get('exam_id')}}" data-class="{{ Request::get('class_id')}}" data-id="{{ $subject->id }}">Save One</button>
                              </div>
                              @if(!empty($getMark))
                              <div style="margin-top:10px;">
                                @php
                                  $getGrade=App\Models\MarksGradeModel::getGrade($total_marks);
                                @endphp

                                Obtain Marks: {{$total_marks}} <br>
                                Passing Marks: {{$subject->passing_marks}} <br>
                                Grade: {{$getGrade}} <br>
                                
                                @if($total_marks >= $subject->passing_marks)
                                  <span style="color:green; font-weight: bolder;">Pass</span>
                                @else
                                  <span style="color:red; font-weight: bolder;">Fail</span>
                                  @php
                                    $pass_fail_vali = 1;
                                  @endphp
                                @endif

                              </div>
                              @endif
                            </td>
                            @php
                            $i++;
                            @endphp
                            @endforeach
                            <td style="text-align: center;vertical-align: middle;"><button type="submit" class="btn btn-success btn-sm">Save All</button>
                              <a target="_blank" href="{{ url('/teacher/my_exam_result/print?exam_id='.Request::get('exam_id').'&student_id='.$student->id) }}" class="btn btn-success btn-sm">Print</a>
                              <br>

                              @if(!empty($total_student_marks))
                                    All Obtain Marks: {{$total_student_marks}} out of 
                                  {{$total_full_marks}} <br>
                                  Total Pass Marks: {{$total_passing_marks}}
                                  <br>

                                    @php
                                      $markPercentage = ($total_student_marks / $total_full_marks) * 100 ;
                                      $getGrade = App\Models\MarksGradeModel::getGrade($markPercentage);
                                    @endphp
                                    Obtain Marks Percentage: <span style="color: green;">{{round($markPercentage,2)}}%</span>
                                  <br>
                                  @if($pass_fail_vali == 0)
                                      Result: <span style="color:green; font-weight: bolder;">Pass</span>
                                  @else
                                      Result: <span style="color:red; font-weight: bolder;">Fail</span>
                                  @endif
                              @endif

                            </td>

                        </tr>
                        </form>
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
  $('.MarksData').submit(function(e){
    e.preventDefault();
    $.ajax({
      type:'post',
      url:'{{ url('/teacher/submit_mark_register') }}',
      data:$(this).serialize(),
      dataType: 'json',
      success: function(data){
        alert(data.message);
      }

    });
  });

    $('.saveSingleSubject').click(function(e){
      var id = $(this).attr('data-id');
      var student_id = $(this).attr('id');
      var subject_id = $(this).attr('data-subject');
      var exam_id = $(this).attr('data-exam');
      var class_id = $(this).attr('data-class');
      var class_work = $('#class_work_'+student_id+subject_id).val();
      var home_work = $('#home_work_'+student_id+subject_id).val();
      var test_work = $('#test_work_'+student_id+subject_id).val();
      var exam = $('#exam_'+student_id+subject_id).val();
      
      $.ajax({
      type:'post',
      url:'{{ url('/teacher/single_submit_mark_register') }}',
      data:{
        "_token":"{{ csrf_token() }}",
        student_id:student_id,
        subject_id:subject_id,
        exam_id:exam_id,
        class_id:class_id,
        class_work:class_work,
        home_work:home_work,
        test_work:test_work,
        exam:exam,
        id:id,
      },
      dataType: 'json',
      success: function(data){
        alert(data.message);
      }

    });
    });
</script>
@endsection




