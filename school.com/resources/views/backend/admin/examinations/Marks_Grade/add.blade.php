@extends('backend.layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{$header_title}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="btn btn-primary" href="{{url('/admin/examinations/mark_grade/list')}}">Exam Marks Grade List</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- form start -->
              <form action="" method="post">
                @csrf
                <div class="card-body">
                  <div class="form-row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Grade Name</label>
                        <input type="text" class="form-control form-control-sm" name="name" placeholder="Grade Name"  value="{{old('name')}}">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Percent From</label>
                        <input type="text" class="form-control form-control-sm" name="percent_from" placeholder="Percent From"  value="{{old('percent_from')}}">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Percent To</label>
                        <input type="text" class="form-control form-control-sm" name="percent_to" placeholder="Percent To"  value="{{old('percent_to')}}">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection




