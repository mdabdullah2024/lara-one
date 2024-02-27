@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> (<span style="color:blueviolet;">{{$user->name}} {{$user->last_name}}</span>) Subject List </h1>
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
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">(<span style="color:blueviolet;">{{$user->name}} {{$user->last_name}}</span>) Subject List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Subject Name</th>
                      <th>Subject Type</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($getRecord as $value)
                   <tr>
                     <td>{{$value->subject_name}}</td>
                     <td>{{$value->subject_type}}</td>
                     <td>
                       <a class="btn btn-primary btn-sm" href="{{url('/parent/my-children/class_timetable/'.$value->class_id.'/'.$value->subject_id.'/'.$user->id)}}">Children Claas Timetable</a>
                     </td>
                   </tr>
                   @endforeach
                  </tbody>
                </table>
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




