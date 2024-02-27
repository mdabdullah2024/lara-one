<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;
class StudentAddFeesModel extends Model
{
    use HasFactory;
    protected $table = 'student_add_fees';

    
    static public function getRecord()
    {
        $return = self::select('student_add_fees.*','users.name as student_name','users.last_name as student_last_name','class.name as class_name','createdBy.name as created_by_name','createdBy.last_name as created_by_last_name')
                    ->join('users','users.id','student_add_fees.student_id')
                    ->join('users  as createdBy','createdBy.id','student_add_fees.created_by')
                    ->join('class','class.id','student_add_fees.class_id')
                    ->where('student_add_fees.is_payment','=',1);
                    if (!empty(Request::get('student_id'))) {
                        $return = $return->where('student_add_fees.student_id','=',Request::get('student_id'));
                    }
                    if (!empty(Request::get('student_name'))) {
                        $return = $return->where('users.name','like','%'.Request::get('student_name').'%');
                    }

                    if (!empty(Request::get('student_lastname'))) {
                        $return = $return->where('users.last_name','like','%'.Request::get('student_lastname').'%');
                    }

                    if (!empty(Request::get('class_id'))) {
                        $return = $return->where('student_add_fees.class_id','=',Request::get('class_id'));
                    }
                    if (!empty(Request::get('start_payment_date'))) {
                        $return = $return->whereDate('student_add_fees.created_at','>=',Request::get('start_payment_date'));
                    }
                    if (!empty(Request::get('end_payment_date'))) {
                        $return = $return->whereDate('student_add_fees.created_at','<=',Request::get('end_payment_date'));
                    }
                    if (!empty(Request::get('payment_type'))) {
                        $return = $return->where('student_add_fees.payment_type','=',Request::get('payment_type'));
                    }
        $return=$return->orderBy('student_add_fees.id','desc')
                    ->paginate(20);
        return $return;
    }



    static public function getFees($student_id)
    {
        $return = self::select('student_add_fees.*','users.name as created_by_name','class.name as class_name','users.last_name as created_by_last_name')
                    ->join('users','users.id','student_add_fees.created_by')
                    ->join('class','class.id','student_add_fees.class_id');
                    
        $return = $return->where('student_add_fees.student_id','=',$student_id)
                    ->where('student_add_fees.is_payment','=',1)
                    ->get();
        return $return;
    }


    static public function paidAmount($student_id,$class_id)
    {
        return self::where('student_add_fees.student_id','=',$student_id)
                    ->where('student_add_fees.class_id','=',$class_id)
                    ->where('student_add_fees.is_payment','=',1)
                    ->sum('student_add_fees.paid_amounts');
    }

    static public function todayTotalPayment()
    {
        return self::where('student_add_fees.created_at','=',date('d-m-Y'))
                    ->where('student_add_fees.is_payment','=',1)
                    ->sum('student_add_fees.paid_amounts');
    }

    static public function TotalFeesReceived()
    {
        return self::select('student_add_fees.id')
                    ->where('student_add_fees.is_payment','=',1)

                    ->sum('student_add_fees.paid_amounts');
    }

    static public function TotalPaidAmounts($student_id)
    {
        return self::select('student_add_fees.id')
                    ->where('student_add_fees.student_id','=',$student_id)
                    ->where('student_add_fees.is_payment','=',1)
                    ->sum('student_add_fees.paid_amounts');
    }


    static public function TotalMyChildPaymentParent($student_ids)
    {
        return self::select('student_add_fees.id')
                    ->whereIn('student_add_fees.student_id',$student_ids)
                    ->where('student_add_fees.is_payment','=',1)
                    ->sum('student_add_fees.paid_amounts');
    }



    
}
