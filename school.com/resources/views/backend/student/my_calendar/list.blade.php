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
  @foreach($getMyTimetable as $value)
    @foreach($value['week'] as $week)
      events.push({
        title:'{{$value['name']}}',
        daysOfWeek:[ {{ $week['full_calendar'] }} ],
        startTime:'{{ (!empty($week))? date('h:i a',strtotime($week['start_time'])) :'' }}',
        endTime:'{{ (!empty($week))? date('h:i a',strtotime($week['end_time'])) :'' }}',
        color:'cyan',
        url:'{{ url('/student/my_timetable/list') }}',
      });
    @endforeach
  @endforeach

  @foreach($getExamTimetable as $valueE)
    @foreach($valueE['exam'] as $exam)
      events.push({
        title:'{{$valueE['name']}}  ({{$exam['subject_name']}})  ({{date('h:i A',strtotime($exam['start_time']))}} to {{date('h:i A',strtotime($exam['end_time']))}})',
        start:'{{ $exam['exam_date'] }}',
        color:'red',
        url:'{{ url('/student/my_exam_timetable/list') }}',
      });
    @endforeach
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