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

            <div class="card card-primary">
              <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label>PayPal Business Email</label>
                    <input type="email" class="form-control" name="paypal_email" placeholder="PayPal Business Email"  value="{{old('paypal_email',$getRecord->paypal_email)}}">
                  </div>
                  <div class="form-group">
                    <label>Fevicon Icon</label>
                    <input type="file" class="form-control" name="fevicon_file" value="{{old('fevicon_file',$getRecord->fevicon_file)}}">
                    @if(!empty($getRecord->fevicon_file))
                    <img class="img img-circle" src="{{$getRecord->Fevicon()}}" style="border:1px solid rgba(0, 0, 0,.2);width: 100px ; height: 110px;margin-top: 5px;">
                    @endif
                  </div>
                  <div class="form-group">
                    <label>Logo</label>
                    <input type="file" class="form-control" name="logo_file" value="{{old('logo_file',$getRecord->logo_file)}}">
                    @if(!empty($getRecord->logo_file))
                    <img class="img img-circle" src="{{$getRecord->getLogo()}}" style="border:1px solid rgba(0, 0, 0,.2);width: 100px ; height: 110px;margin-top: 5px;">
                    @endif
                  </div>
                </div>
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




