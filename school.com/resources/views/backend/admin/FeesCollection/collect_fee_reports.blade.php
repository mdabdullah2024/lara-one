@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Collect Fees Reports</h1>
          </div>
           
          <div class="col-md-12 mt-1">
            @include('backend.layouts.message')
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
      <div class="card m-3">
          <div class="card-header">
            <h3 class="card-title">Search Attendance Reports</h3>
          </div>
          <form action="" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Student ID</label>
                      <input type="text" name="student_id" class="form-control form-control-sm" value="{{Request::get('student_id')}}" placeholder="Student ID">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Student First Name</label>
                      <input type="text" name="student_name" class="form-control form-control-sm" value="{{Request::get('student_name')}}" placeholder="Student Name">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Student Last Name</label>
                      <input type="text" name="student_lastname" class="form-control form-control-sm" value="{{Request::get('student_lastname')}}" placeholder="Student Name">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Class</label>
                      <select class="form-control form-control-sm" name="class_id"  id="GetClass" >
                        <option value="">Select</option>
                        @foreach($getClass as $value)
                        <option {{ (Request::get('class_id')==$value->id?'selected':'') }} value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Payment Types</label>
                      <select class="form-control form-control-sm " name="payment_type" id="payment_type">
                        <option value="">Select</option>
                        <option {{ (Request::get('payment_type')=="Paypal"?'selected':'') }} value="Paypal">Paypal</option>
                        <option {{ (Request::get('payment_type')=="cash"?'selected':'') }} value="cash">Cash</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Start Payment Date</label>
                      <input type="date" name="start_payment_date" value="{{Request::get('start_payment_date')}}" id="GetDate" class="form-control form-control-sm" >
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>End Payment Date</label>
                      <input type="date" name="end_payment_date" value="{{Request::get('end_payment_date')}}" id="GetDate" class="form-control form-control-sm" >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{url('/admin/fees_collection/collect_fees_reports')}}"> Reset </a>
                    </div>
                </div>
              </div>
          </div>
        </form>
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Student List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Student Name</th>
                      <th>Class Name</th>
                      <th>Total Amounts($)</th>
                      <th>Paid Amounts($)</th>
                      <th>Remaining Amounts($)</th>
                      <th>Payment Type</th>
                      <th>Remark</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                    </tr>
                  </thead>
                  <tbody>

                    @if(!empty($getRecord))
                     @forelse($getRecord as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->student_name }} {{ $value->student_last_name }}</td>
                        <td>{{ $value->class_name }}</td>
                        <td>${{ number_format($value->total_amounts) }}</td>
                        <td>${{ number_format($value->paid_amounts) }}</td>
                        <td>${{ number_format($value->remaining_amounts) }}</td>
                        <td>{{ $value->payment_type }}</td>
                        <td>{{ $value->remark }}</td>
                        <td>{{ $value->created_by_name }} {{ $value->created_by_last_name }}</td>

                        <td>{{ date('d-m-Y',strtotime($value->created_at)) }}</td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="100%">Record Not Found!</td>
                      </tr>
                      @endforelse
                    @endif
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





