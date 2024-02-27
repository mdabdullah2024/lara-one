@extends('backend.layouts.app')
@section('style')
  <link rel="stylesheet" href="{{ url('public/backend/plugins/select2/css/select2.min.css')}}">
  <style type="text/css">
    .select2-container .select2-selection--single {height: 40px}
  </style>
@endsection
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
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 mt-1">
            @include('backend.layouts.message')
        </div>
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- form start -->
              <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label>Subject</label>
                    <input type="text" class="form-control" name="subject" placeholder="Subject"  value="{{old('subject')}}">
                    <font style="color:red;">{{$errors->first('subject')}}</font>
                  </div>
                  <div class="form-group">
                  <label>User(Teacher / Student / Parent</label>
                  <select name="user_id" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                  </select>
                </div>
                  <div class="form-group">
                    <label>Message To</label><br>
                    <label style="margin-right: 20px;">
                        <input type="checkbox" name="message_to[]" value="2">Teacher
                      </label>
                    <label style="margin-right: 20px;">
                      <input type="checkbox" name="message_to[]" value="3">Student
                    </label>
                    <label style="margin-right: 20px;">
                      <input type="checkbox" name="message_to[]" value="4">Parent
                    </label>
                  </div>
                  <div class="form-group">
                    <label>Message</label>
                    <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px">
                    </textarea>
                  </div>
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Send Email</button>
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
<script src="{{url('public/backend/plugins/select2/js/select2.full.min.js')}}"></script>

<script type="text/javascript">
$(function () {

//ajax call
  $('.select2').select2({
    ajax:{
      url:'{{url('admin/communicate/search_user')}}',
      dataType:'json',
      delay:250,
      data: function (data) {
        return {
          search:data.term,
        };
      },
      processResults: function(response) {
        return {
          results: response
        };
      },
    }
  });



    //Add text editor
    $('#compose-textarea').summernote({
      height:220,
    });
  });
</script>
@endsection
