@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $header_title }}</h1>
          </div>
         
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li><a class="btn btn-primary" href="{{ url('/admin/examinations/mark_grade/add') }}">Add New Marks Grade</a></li>
            </ol>
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
                <h3 class="card-title">Marks Grade List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Grade Name</th>
                      <th>Percent From</th>
                      <th>Percent To</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($getRecord as $value)
                    <tr>
                      <td>{{ $value->name }}</td>
                      <td>{{ $value->percent_from }}</td>
                      <td>{{ $value->percent_to }}</td>
                      <td>{{ $value->user_name }} {{ $value->user_lastname }}</td>
                      <td>{{ date('d-m-Y h:i A',strtotime($value->created_at)) }}</td>
                      <td>
                        <a title="Edit" href="{{ url('/admin/examinations/mark_grade/edit/'.$value->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <a title="Delete" href="{{ url('/admin/examinations/mark_grade/delete/'.$value->id) }}" class="btn btn-danger btn-sm">Delete</a>
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




