@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Collect Fees <span style="color: blue;">({{ $getStudent->name }} {{ $getStudent->last_name }})</span></h1>
          </div>
          <div class="col-sm-6">
            <button style="float: right;" id="addFees" type="button" class="btn btn-primary">Add Fees</button>
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
                <h3 class="card-title">Student List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Class Name</th>
                      <th>Total Amounts($)</th>
                      <th>Paid Amounts($)</th>
                      <th>Remaining Amounts($)</th>
                      <th>Payment Type</th>
                      <th>Remark</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    @if(!empty($getFees))
                     @forelse($getFees as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
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

  <div class="modal fade" id="addFeesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Fees </h1>
        <button type="button" class="btn-light " data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        @php
        $total_amounts = $getStudent->class_amounts;
          $remaining_amounts =  $total_amounts - $paid_amounts;
        @endphp
        <form action="" method="post" enctype="multipart/form-data">
          @csrf
          <div class=" ">
            <label for="" class="col-form-label">Class Name: {{ $getStudent->class_name }}</label>
          </div>
          <div class=" ">
            <label for="amounts" class="col-form-label">Total Amounts: {{ number_format($getStudent->class_amounts,2) }}</label>
          </div>
          <div class="">
            <label for="amounts" class="col-form-label">Paid Amounts: {{number_format($paid_amounts,2)}}</label>
          </div>
          <div class="">
            <label for="amounts" class="col-form-label">Remaining Amounts: {{number_format($remaining_amounts,2)}}</label>
          </div>
          <div class="mb-3 ">
            <label for="amounts" class="col-form-label">Amounts <span style="color:red;">*</span></label>
            <input type="number" class="form-control form-control-sm" id="Amounts" name="amounts" placeholder="$ Amounts " required>
          </div>
          <div class="mb-3">
            <label for="payment_type" class="col-form-label">Payment Types<span style="color:red;">*</span></label>
            <select class="form-control form-control-sm" name="payment_type" required>
              <option value="">Select</option>
              <option value="cash">Cash</option>
              <option value="cheque">cheque</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Remark </label>
            <textarea name="remark" class="form-control form-control-sm" rows="" cols="5"></textarea>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Payment</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('script')
  <script type="text/javascript">
    $('#addFees').click(function(){
      $('#addFeesModal').modal('show');
    });
  </script>
@endsection




