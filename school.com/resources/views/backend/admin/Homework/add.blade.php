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
              <li class="breadcrumb-item"><a class="btn btn-primary" href="{{url('/admin/homework/homework')}}">Homework</a></li>
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
              <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label>Class <span style="color:red;">*</span> </label>
                    <select class="form-control " name="class_id" id="getClass" required>
                      <option value="">Select Class</option>
                      @foreach($getClass as $class)
                      <option value="{{ $class->id }}">{{ $class->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Subject <span style="color:red;">*</span></label>
                    <select class="form-control " id="getSubject" name="subject_id"  required>
                      <option value="">Select Subject</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Homework Date <span style="color:red;">*</span></label>
                    <input type="date" class="form-control" name="homework_date"  value="{{old('homework_date')}}" required>
                  </div>
                  <div class="form-group">
                    <label>Submission Date <span style="color:red;">*</span></label>
                    <input type="date" class="form-control" name="submission_date"  value="{{old('submission_date')}}" required>
                  </div>
                  <div class="form-group">
                    <label>Document</label>
                    <input type="file" class="form-control" name="document_file"  value="{{old('document_file')}}">
                  </div>
                  <div class="form-group">
                    <label>Description <span style="color:red;">*</span></label>
                    <textarea id="compose-textarea" name="description" class="form-control" style="height: 300px" required>
                    </textarea>
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
@section('script')
<script type="text/javascript">
$(function () {
    //Add text editor
    $('#compose-textarea').summernote({
      height:220,
    });
    $('#getClass').change(function(){
      var class_id = $(this).val();
      $.ajax({
        type:"POST",
        url: "{{ url('/admin/ajax_get_subject')}}",
        data:{
          "_token":"{{csrf_token()}}",
          class_id: class_id,
        },
        dataType: "json",
        success: function(data){
          $('#getSubject').html(data.success);
        }
      });
    });

  });
</script>
@endsection
