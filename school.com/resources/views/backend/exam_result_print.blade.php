<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Exam Result</title>
    <style type="text/css">
        @page{
            size: 8.3in 11.7in;
        }
         @page{
            size: A4;
        }
        @media print{
            @page{
                margin:0;
                margin-left: 20px;
                margin-right: 20px;
            }
        }
        .margin_bottom{
            margin-bottom: 3px solid #222;
        }
        .result-bg{
            background: #fff;
        }
        .result-bg .result-table{
            border-collapse: collapse;
            text-align: center;
            font-size: 15px;
            width: 100%;
        }
       .result-bg  .result-table .th{
            border: 1px solid #333;
            padding: 10px;
        }

        .result-bg  .result-table .td{
            border: 1px solid #333;
            padding: 3px;
        }
        .text-container{
            text-align: left;
            word-wrap: unset;
        }
    </style>
    <link rel="icon" type="image/jpg" href="{{$getSetting->Fevicon()}}">
</head>
<body>
    <div id="page">
        <table style="width:100%; text-align: center;">
            <tr>
                <td width="5%"></td>
                <td width="15%"><img width="88px" height="88px" src="{{$getSetting->getLogo()}}"></td>
                <td align="left">
                    <h1>{{$getSetting->school_name}} <br> <span style="color: green; font-weight:bold; font-size: 15px;">{{$getSetting->description}}</span> </h1>

                </td>
            </tr>
        </table>
        <table style="width:100%;">
            <tr>
                <td width="5%"></td>
                <td width="70%">
                    <table class="margin_bottom" style="width:100%;">
                        <tbody>
                            <tr>
                                <td width="13%">Name Of Student:</td>
                                <td style="border-bottom: 2px solid #222;width:100%;">{{ $getStudent->name }} {{ $getStudent->last_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="margin_bottom" style="width:100%;">
                        <tbody>
                            <tr>
                                <td width="11%">Admission No:</td>
                                <td style="border-bottom: 2px solid #222;width:30%;">{{ $getStudent->admission_number }}</td>
                                <td width="5%">Class:</td>
                                <td style="border-bottom: 2px solid #222;width:70%;">{{ $getClass->class_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <table class="margin_bottom" style="width:100%;">
                        <tbody>
                            <tr>
                                <td width="4%">Term:</td>
                                <td style="border-bottom: 2px solid #222;width:90%;">{{ $getExam->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width:5%;"></td>
                <td style="width:20%;" valign="top">
                    <img style="border-radius: 6px;" width="100px" height="100px" src="{{$getStudent->getProfile()}}">
                    <br>
                    Gender: {{$getStudent->gender}}
                </td>
            </tr>
        </table>
        <br>
        <div class="result-bg">
            <table class="result-table">
                  <thead>
                    <tr>
                      <th style="font-weight: bolder;" class="th text-container">Subject</th>
                      <th style="font-weight: bolder;" class="th">Class Work</th>
                      <th style="font-weight: bolder;" class="th">Test Work</th>
                      <th style="font-weight: bolder;" class="th">Home Work</th>
                      <th style="font-weight: bolder;" class="th">Exam </th>
                      <th style="font-weight: bolder;" class="th">Obtain Marks </th>
                      <th style="font-weight: bolder;" class="th">Full Marks</th>
                      <th style="font-weight: bolder;" class="th">Passing Marks</th>
                      <th style="font-weight: bolder;" class="th">Result</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $grandTotal = 0;
                        $allSubFullMarks = 0;
                        $pass_fail_vali = 0;
                    @endphp

                    @foreach($getExamMark as $exam)

                    @php
                      $grandTotal = $grandTotal + $exam['obtain_marks'];
                      $allSubFullMarks = $allSubFullMarks + $exam['full_marks'];
                    @endphp
                    <tr>
                      <th class="td text-container " style="font-weight: bolder;">{{ $exam['subject_name']}}</th>
                      <td class="td">{{ $exam['class_work']}}</td>
                      <td class="td">{{ $exam['test_work']}}</td>
                      <td class="td">{{ $exam['home_work']}}</td>
                      <td class="td">{{ $exam['exam']}}</td>
                      <td class="td">{{ $exam['obtain_marks']}}</td>
                      <td class="td">{{ $exam['full_marks']}}</td>
                      <td class="td">{{ $exam['passing_marks']}}</td>
                      <td class="td">
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
                      <td class="td" colspan="2">
                          <b>Grand Total :</b>{{$grandTotal}}/{{$allSubFullMarks}}
                      </td>
                      <td class="td" colspan="2">
                        @php
                          $Percentage='';
                          $Percentage = round(($grandTotal * 100) / $allSubFullMarks,2);
                          $getGrade = App\Models\MarksGradeModel::getGrade($Percentage);
                        @endphp
                          <p><b>Obtain Percentage: </b>{{ $Percentage }}%</p>
                      </td>
                      <td class="td" colspan="2">
                        
                          <p><b>Grade: </b>{{$getGrade}}
                          </p>
                      </td>
                      <td class="td" colspan="3">
                        
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
<br><br>
<br><br>
                <table class="margin_bottom" style="width:50%;">
                        <tbody>
                            <tr>
                                <h2>Headmaster/Principal</h2>
                                <td width="5%">
                                    <span style="font-size: 20px; font-weight: bolder;">Signature:</span style="font-size: 20px; font-weight: bolder;">
                                </td>
                                <td width="95%"  style="border-bottom: 2px solid #222; "></td>
                            </tr>
                        </tbody>
                    </table>
        </div>

    </div>
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>