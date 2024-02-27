@extends('backend.layouts.app')
@section('content')
@section('style')
<style type="text/css">
  .fc-daygrid-event {
    border-radius: 3px;
    font-size: var(--fc-small-font-size);
    position: relative;
    white-space: normal;
</style>
@endsection

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Calendar</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div id="calendar"></div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>

@endsection

@section('script')
<script type="text/javascript" src="{{ url('public/backend/fullCalendar/index.global.js') }}"></script>
<script type="text/javascript">
  var events = new Array();
  @foreach($getTimetable as $value)
   
      events.push({
        title:'Cls: {{$value->class_name}} Sub: {{$value->subject_name}}',
        daysOfWeek:[{{$value->fullCalendar_day}}],
        startTime:'{{$value->start_time}}',
        endTime:'{{$value->end_time}}',
        color: '#76c',
        
        
      });
   
  @endforeach 

  @foreach($getExamTimetable as $exam)
    
      events.push({
        title:'Cls: {{$exam->class_name}} Exam:{{$exam->exam_name}} Sub:{{$exam->subject_name}} {{date('h:i A',strtotime($exam->start_time))}} To {{date('h:i A',strtotime($exam->end_time))}}',
        start:'{{$exam->exam_date}}',
        end:'{{$exam->exam_date}}',
        color:'red',
        url:'{{url('/teacher/my_exam_timetable')}}',
      });

  @endforeach

  var calendarID = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarID, {
    headerToolbar:{
      left:'prev,next today',
      center:'title',
      right:'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
    initialDate: '<?=date('Y-m-d') ?>',
    navLinks: true,
    editable: false,
    events: events,
  });

  calendar.render();
</script>
@endsection