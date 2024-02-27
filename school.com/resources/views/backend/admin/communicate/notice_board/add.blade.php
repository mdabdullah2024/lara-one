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
              <li class="breadcrumb-item"><a class="btn btn-primary" href="{{url('/admin/communicate/notice_board')}}">Notice Board</a></li>
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
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Title"  value="{{old('title')}}">
                    <font style="color:red;">{{$errors->first('title')}}</font>
                  </div>
                  <div class="form-group">
                    <label>Notice Date</label>
                    <input type="date" class="form-control" name="notice_date"  value="{{old('notice_date')}}">
                  </div>
                  <div class="form-group">
                    <label>Publish Date</label>
                    <input type="date" class="form-control" name="publish_date"  value="{{old('publish_date')}}">
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
  });
</script>
@endsection
