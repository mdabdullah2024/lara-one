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
              <li class="breadcrumb-item"><a class="btn btn-primary" href="{{route('admin.assign_class_teacher.list')}}">Assign Class Teacher List</a></li>
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
                  <div class="form-group">
                    <label>Assign Class Name</label>
                    <select class="form-control form-control-sm" required name="class_id">
                      <option value="">Select Class</option>
                      @foreach($getClasses as $class)
                      <option {{($getRecord->class_id == $class->id)?'selected':''}} value="{{$class->id}}">{{$class->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Teacher Name</label>
                    @foreach($getTeacher as $teacher)
                    <div>
                      @php
                        $checked = '';
                      @endphp
                      @foreach($getAssignClassTeacherID as $teacherID)
                      
                        @if($teacherID->teacher_id == $teacher->id)
                          @php
                            $checked = 'checked';
                        @endphp
                          
                        @endif
                      @endforeach
                      <label style="font-weight: normal;">
                        <input {{$checked}} type="checkbox"  value="{{$teacher->id}}" name="teacher_id[]"> {{$teacher->name}} {{$teacher->last_name}}
                      </label>
                    </div>
                    @endforeach
                  </div>

                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control form-control-sm" name="status">
                      <option {{($getRecord->status==0)?'selected':''}} value="0">Active</option>
                      <option {{($getRecord->status==1)?'selected':''}} value="1">Inactive</option>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
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




