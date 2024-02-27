<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\StudentAddFeesModel;
use App\Models\SettingsModel;
use App\Models\User;
use Auth;

class FeesCollectionController extends Controller
{
    public function CollectFees(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        if (!empty($request->all())) {
            $data['getRecord'] = User::getFeesCollectionStudent();
        }
        $data['header_title'] = 'Collect Fees';
        return view('backend.admin.FeesCollection.collect_fee',$data);
    }

    public function CollectFeesAdd($student_id)
    {
        $getStudent = User::getStudentClassPayment($student_id);
        $data['paid_amounts'] = StudentAddFeesModel::paidAmount($student_id,$getStudent->class_id);
        $data['getStudent'] = $getStudent;
        $data['getFees']  = StudentAddFeesModel::getFees($student_id);
        $data['header_title'] = 'Add Collect Fees';
        return view('backend.admin.FeesCollection.add_collect_fee',$data);
    }
    public function CollectFeesAddSubmit($student_id,Request $request)
    {
        $getStudentClassSingle = User::getStudentClassPayment($student_id);
        $paid_amounts = StudentAddFeesModel::paidAmount($student_id,$getStudentClassSingle->class_id);
        $total_amounts = $getStudentClassSingle->class_amounts;

        if (!empty($request->amounts)) {
            $remaining_amounts =  $total_amounts - $paid_amounts;
            $remaining_amounts_user = $remaining_amounts - $request->amounts;
            if ($remaining_amounts >= $request->amounts) {
                $payment = new StudentAddFeesModel();
                $payment->student_id = $student_id;
                $payment->class_id = $getStudentClassSingle->class_id;
                $payment->total_amounts = $remaining_amounts;
                $payment->paid_amounts = $request->amounts;
                $payment->remaining_amounts = $remaining_amounts_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->is_payment = 1;
                $payment->created_by = Auth::user()->id;
                $payment->save();

                return redirect()->back()->with('success','Payment Successfully added.');
            }else{
                return redirect()->back()->with('error','Your Amounts Greater than Remaining Amounts');

            }
        }
        else{
                return redirect()->back()->with('error','Your Amounts will be greater than $0');

        }

        
    }
    public function CollectFeesReports(Request $request)
        {
            $data['getClass'] = ClassModel::getClass();
            $data['getRecord'] = StudentAddFeesModel::getRecord();
            $data['header_title'] = 'Collect Fees Reports';
            return view('backend.admin.FeesCollection.collect_fee_reports',$data);
        }


//student side fees collection
    public function CollectFeesStudent()
    {
        $student_id = Auth::user()->id;
        $class_id = Auth::user()->class_id;
        $getStudent = User::getStudentClassPayment($student_id);
        $data['paid_amounts'] = StudentAddFeesModel::paidAmount($student_id,$getStudent->class_id);
        $data['getStudent'] = $getStudent;
        $data['getFees']  = StudentAddFeesModel::getFees($student_id);
        $data['header_title'] = 'Add Collect Fees';
        return view('backend.student.FeesCollection.fees_collection',$data);
    }

     public function CollectFeesStudentSubmit(Request $request)
    {
        $student_id = Auth::user()->id;
        $class_id = Auth::user()->class_id;
        $getStudentClassSingle = User::getStudentClassPayment($student_id);
        $paid_amounts = StudentAddFeesModel::paidAmount($student_id,$class_id);
        $total_amounts = $getStudentClassSingle->class_amounts;

        if (!empty($request->amounts)) {
            $remaining_amounts =  $total_amounts - $paid_amounts;
            $remaining_amounts_user = $remaining_amounts - $request->amounts;
            if ($remaining_amounts >= $request->amounts) {
                $payment = new StudentAddFeesModel();
                $payment->student_id = $student_id;
                $payment->class_id = $getStudentClassSingle->class_id;
                $payment->total_amounts = $remaining_amounts;
                $payment->paid_amounts = $request->amounts;
                $payment->remaining_amounts = $remaining_amounts_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                if (!empty($request->payment_type=='cash')) {
                    $payment->is_payment = 1;
                }
                $payment->created_by = Auth::user()->id;
                $payment->save();

                $getSettings = SettingsModel::getSingle();

                if ($request->payment_type == 'Paypal') {

                    $query = array();
                    $query['business']  = $getSettings->paypal_email;
                    $query['cmd']  = '_xclick';
                    $query['item_name']  = "Students Fees";
                    $query['no_shipping']  = '1';
                    $query['item_number']  = $payment->id;
                    $query['amounts']  = $request->amounts;
                    $query['currency_code']  = 'USD';
                    $query['cancel_return']  = url('student/paypal/payment-error');
                    $query['return']  = url('student/paypal/payment-success');
                    $query_string  = http_build_query($query);
                    header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?'.$query_string);
                    exit();
                    
                }


                return redirect()->back()->with('success','Payment Successfully added.');

            }
            else{
                return redirect()->back()->with('error','Your Amounts Greater than Remaining Amounts');

            }
        }
        else{
                return redirect()->back()->with('error','Your Amounts will be greater than $0');

        }

        
    }


    public function PaymentError()
    {
        return redirect('/student/fees_collection')->with('error','Due to error try again');
    }

    public function PaymentSuccess()
    {
        if (!empty($request->item_number) && !empty($request->st) && $request->st == 'Completed') {
            $fees = StudentAddFeesModel::getSingle($request->item_number);
            if (!empty($fees)) {
                $fees->is_payment = 1;
                $fees->payment_data = json_encode($request->all());
                $fees->save();
                return redirect('student/fees_collection')->with('success','Your Payment Successfully done.');

            }
            else
            {
                return redirect('student/fees_collection')->with('error','Due to Some error Please try again.');

            }
        }
        else
        {
            return redirect('student/fees_collection')->with('error','Due to Some error Please try again.');
        }
    }

//parent side work
    public function myChildFeesCollection($student_id)
    {

        $getStudent = User::getStudentClassPayment($student_id);
        $data['paid_amounts'] = StudentAddFeesModel::paidAmount($student_id,$getStudent->class_id);
        $data['getStudent'] = $getStudent;
        $data['getFees']  = StudentAddFeesModel::getFees($student_id);
        $data['header_title'] = 'Add Collect Fees';
        return view('backend.parent.FeesCollection.fees_collection',$data); 
    }
    public function myChildFeesCollectionSubmit(Request $request,$student_id)
    {
        $getStudentClassSingle = User::getStudentClassPayment($student_id);
        $paid_amounts = StudentAddFeesModel::paidAmount($student_id,$getStudentClassSingle->class_id);
        $total_amounts = $getStudentClassSingle->class_amounts;

        if (!empty($request->amounts)) {
            $remaining_amounts =  $total_amounts - $paid_amounts;
            $remaining_amounts_user = $remaining_amounts - $request->amounts;
            if ($remaining_amounts >= $request->amounts) {
                $payment = new StudentAddFeesModel();
                $payment->student_id = $student_id;
                $payment->class_id = $getStudentClassSingle->class_id;
                $payment->total_amounts = $remaining_amounts;
                $payment->paid_amounts = $request->amounts;
                $payment->remaining_amounts = $remaining_amounts_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                if (!empty($request->payment_type=='cash')) {
                    $payment->is_payment = 1;
                }
                $payment->created_by = Auth::user()->id;
                $payment->save();

                $getSettings = SettingsModel::getSingle();

                if ($request->payment_type == 'Paypal') {

                    $query = array();
                    $query['business']  = $getSettings->paypal_email;
                    $query['cmd']  = '_xclick';
                    $query['item_name']  = "Students Fees";
                    $query['no_shipping']  = '1';
                    $query['item_number']  = $payment->id;
                    $query['amounts']  = $request->amounts;
                    $query['currency_code']  = 'USD';
                    $query['cancel_return']  = url('student/paypal/payment-error');
                    $query['return']  = url('student/paypal/payment-success');
                    $query_string  = http_build_query($query);
                    header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?'.$query_string);
                    exit();
                    
                }


                return redirect()->back()->with('success','Payment Successfully added.');

            }
            else{
                return redirect()->back()->with('error','Your Amounts Greater than Remaining Amounts');

            }
        }
        else{
                return redirect()->back()->with('error','Your Amounts will be greater than $0');

        }
    }
    
}
