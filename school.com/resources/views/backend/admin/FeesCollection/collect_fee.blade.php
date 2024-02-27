@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Collect Fees</h1>
          </div>
           
          <div class="col-md-12 mt-1">
            @include('backend.layouts.message')
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
      <div class="card m-3">
          <div class="card-header">
            <h3 class="card-title">Search Collect Fees Student</h3>
          </div>
          <form action="" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Class</label>
                      <select class="form-control form-control-sm" name="class_id" value="{{Request::get('class_id')}}">
                        <option value="">Select</option>
                        @foreach($getClass as $class)
                        <option {{ (Request::get('class_id') == $class->id)?'selected':'' }} value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Student ID</label>
                      <input type="text" class="form-control form-control-sm" name="student_id" value="{{Request::get('student_id')}}" placeholder="Student ID"  >
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Student First Name</label>
                      <input type="text" class="form-control form-control-sm" name="first_name" value="{{Request::get('first_name')}}" placeholder="Student First Name"  >
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group ">
                      <label>Student Last Name</label>
                      <input type="text" class="form-control form-control-sm" name="last_name" value="{{Request::get('last_name')}}" placeholder="Student Last Name"  >
                    </div>
                  </div>
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <button style="margin-top: 31px;" type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a style="margin-top: 31px;" class="btn btn-success btn-sm" href="{{url('/admin/fees_collection/collect_fees')}}"> Reset </a>
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
                <h3 class="card-title">Collect Fees</h3>
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
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(!empty($getRecord))
                     @forelse($getRecord as $value)
                     @php

                      $paid_amounts = $value->getPaidAmounts($value->id,$value->class_id);
                      $total_amounts = $value->class_amounts;
                      $remaining_amounts =  $total_amounts - $paid_amounts;
                     @endphp
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }} {{ $value->last_name }}</td>
                        <td>{{ $value->class_name }}</td>
                        <td>{{ $total_amounts }}</td>
                        <td>{{ $paid_amounts }}</td>
                        <td>{{ $remaining_amounts }}</td>
                        <td>{{ date('d-m-Y',strtotime($value->created_at)) }}</td>
                        <td>
                          <a href="{{ url('/admin/fees_collection/collect_fees/add_fees/'.$value->id) }}" class="btn btn-success">{{ ($remaining_amounts == 0)?'Paid': 'Collect Fees' }}</a>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="100%">Record Not Found!</td>
                      </tr>
                      @endforelse
                    @endif
                  </tbody>
                </table>
                @if(!empty($getRecord))
                <div style=" margin-top: 10px; text-align: center; float:right;">{!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}</div>
                @endif
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




