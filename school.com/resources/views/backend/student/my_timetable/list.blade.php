@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Class Timetable</h1>
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
            <div class="card">
             
              <div class="card-header">
                <h3 class="card-title">{{$value['name']}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
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
                     @foreach($value['week'] as $valueW)
                     <tr>
                        <th>{{$valueW['week_name']}}</th>
                        <td>{{date('H:i A',strtotime($valueW['start_time']))}}</td>
                        <td>{{date('H:i A',strtotime($valueW['end_time']))}}</td>
                        <td>{{$valueW['room_number']}}</td>
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
    @endforeach
  </div>

@endsection


