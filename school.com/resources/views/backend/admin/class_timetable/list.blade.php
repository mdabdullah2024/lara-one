@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Class Timetable</h1>
          </div>
          <div class="col-md-12 mt-1">
            @include('backend.layouts.message')
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
      <div class="card m-3">
          <div class="card-header">
            <h3 class="card-title">Search Class Timetable</h3>
          </div>
          <form action="" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group ">
                      <label>Class Name</label>
                      <select class="form-control form-control-sm getClass" name="class_id" id="class_id" required>
                        <option value="">Select</option>

                        @foreach($getClass as $class)
                        <option {{(Request::get('class_id') == $class->id)?'selected':''}} value="{{$class->id}}">{{$class->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group ">
                      <label>Subject Name</label>
                      <select class="form-control form-control-sm getSubject" name="subject_id" required>
                          <option value="">Select</option>
                          @if(!empty($getSubject))
                          @foreach($getSubject as $subject)
                        <option {{(Request::get('subject_id') == $subject->subject_id)?'selected':''}} value="{{$subject->subject_id}}">{{$subject->subject_name}}</option>
                        @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2 ">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{route('admin.class_timetable.list')}}"> Reset </a>
                    </div>
                </div>
              </div>
          </div>
        </form>
    </div>
    @if(!empty(Request::get('class_id')) && !empty(Request::get('subject_id')))
    <form action="{{route('admin.class_timetable.add')}}" method="post" >
      @csrf
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Class Timetable </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                
                  <input type="hidden" name="class_id" class="form-control form-control-sm" value="{{Request::get('class_id')}}">

                  <input type="hidden" name="subject_id" class="form-control form-control-sm" value="{{Request::get('subject_id')}}">
                  <table class="table table-striped" width="100%">
                    <thead> 
                        <tr>
                          <th>Week</th>
                          <th>Start Time</th>
                          <th>End Time</th>
                          <th>Room No</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                      $i = 1;
                      @endphp
                      @foreach($week as $value)
                     <tr>
                        <th>
                       <input type="hidden" name="timetable[{{$i}}][week_id]" class="form-control form-control-sm" value="{{$value['week_id']}}">
                        {{$value['week_name']}}
                      </th>
                        <td>
                          <input style="width:200px" type="time" name="timetable[{{$i}}][start_time]" value="{{$value['start_time']}}" class="form-control form-control-sm" >
                        </td>
                        <td>
                          <input style="width:200px" type="time" name="timetable[{{$i}}][end_time]" value="{{$value['end_time']}}" class="form-control form-control-sm" >
                        </td>
                        <td>
                          <input style="width:200px" type="text" name="timetable[{{$i}}][room_number]" value="{{$value['room_number']}}" class="form-control form-control-sm">
                        </td>
                     </tr>
                     @php
                      $i++;
                      @endphp
                     @endforeach
                    </tbody>
                  </table>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-sm mb-2">Submit</button>
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @endif
  </div>
@endsection
@section('script')
  <script type="text/javascript">
    $('.getClass').change(function(){
      var class_id = $(this).val();
      $.ajax({
        url: "{{url('admin/class_timetable/get_subject')}}",
        type:"POST",
        data:{
          "_token": "{{ csrf_token() }}",
          class_id:class_id,
        },
        dataType:"json",
        success:function(response){
          $('.getSubject').html(response.html);
        },
      });
    });
  </script>
@endsection



