@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $header_title }}</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <form action="" method="get" >
    <div class="card m-3">
          <div class="card-header">
            <h3 class="card-title">Search Notice Board</h3>
          </div>
            <div class="card-body">
                <div class="row">
                  
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Title</label>
                      <input type="text" class="form-control form-control-sm" name="title" value="{{Request::get('title')}}" placeholder="Title"  >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Notice Date From </label>
                      <input type="date" class="form-control form-control-sm" name="notice_date_from" value="{{Request::get('notice_date_from')}}"  >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Notice Date To </label>
                      <input type="date" class="form-control form-control-sm" name="notice_date_to" value="{{Request::get('notice_date_to')}}"  >
                    </div>
                  </div>

                  <div class="col-md-3 ">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{url('/teacher/my_notice_board')}}"> Reset </a>
                    </div>
                </div>
                </form>
              </div>
          </div>
        </form>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col -->
          @foreach($getRecord as $value)
        <div class="col-md-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Read Notice Board</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-read-info">
                <h5>{{$value->title}}</h5>
                  <h6><span class="mailbox-read-time float-right">{{date('d-m-Y h:i A',strtotime($value->created_at))}}</span></h6>
              </div>
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                    {!!$value->message!!}
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        @endforeach
      </div>
      <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
</div>
@endsection




