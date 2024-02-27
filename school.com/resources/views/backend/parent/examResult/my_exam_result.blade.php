@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Child Exam Result ( <span style="color:blueviolet;">{{ $getStudent->name }} {{ $getStudent->last_name }}</span> )</h1>
          </div>
           
          <div class="col-md-12 mt-1">
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          @foreach($getRecord as $value)
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{$value['exam_name']}}
                  
                </h3>
                <h3 style="display: block; text-align:right;">
                  <a target="_blank" href="{{ url('/parent/my_exam_result/print?exam_id='.$value['exam_id'].'&student_id='.$getStudent->id) }}" class="btn btn-success btn-sm">Print</a>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Subject</th>
                      <th>Class Work</th>
                      <th>test Work</th>
                      <th>Home Work</th>
                      <th>Exam </th>
                      <th>Obtain Marks </th>
                      <th>Full Marks</th>
                      <th>Passing Marks</th>
                      <th>Result</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $grandTotal = 0;
                        $allSubFullMarks = 0;
                        $pass_fail_vali = 0;
                    @endphp

                    @foreach($value['subject'] as $exam)

                    @php
                      $grandTotal = $grandTotal + $exam['obtain_marks'];
                      $allSubFullMarks = $allSubFullMarks + $exam['full_marks'];
                    @endphp
                    <tr>
                      <th>{{ $exam['subject_name']}}</th>
                      <td>{{ $exam['class_work']}}</td>
                      <td>{{ $exam['test_work']}}</td>
                      <td>{{ $exam['home_work']}}</td>
                      <td>{{ $exam['exam']}}</td>
                      <td>{{ $exam['obtain_marks']}}</td>
                      <td>{{ $exam['full_marks']}}</td>
                      <td>{{ $exam['passing_marks']}}</td>
                      <td>
                        @if($exam['obtain_marks'] >= $exam['passing_marks'])
                          <span style="color: green; font-weight: bolder;">Pass</span>
                        @else
                        @php
                        $pass_fail_vali = 1;
                        @endphp
                          <span style="color: red; font-weight: bolder;">Fail</span>
                        @endif
                      </td>
                    </tr>
                    
                    @endforeach
                    <tr>
                      <td colspan="2">
                          <b>Grand Total :</b> {{$grandTotal}}/{{$allSubFullMarks}}
                      </td>
                      @php
                          $Percentage='';
                          $Percentage = round(($grandTotal * 100) / $allSubFullMarks,2);
                          $getGrade = App\Models\MarksGradeModel::getGrade($Percentage);
                        @endphp
                      <td colspan="2">
                          <p><b>Obtain Percentage: </b>{{$Percentage}}%</p>
                      </td>
                      <td colspan="2">
                        
                          <p><b>Grade: </b>{{$getGrade}}
                          </p>
                      </td>
                      <td colspan="3">
                        
                          <p><b>Result:</b>
                            @if($pass_fail_vali == 0)
                          <span style="color: green; font-weight: bolder;">Pass</span>
                            @else
                          <span style="color: red; font-weight: bolder;">Fail</span>
                            @endif
                          </p>
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>
          </div>
        </div>

        @endforeach

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection




