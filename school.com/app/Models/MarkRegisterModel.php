<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkRegisterModel extends Model
{
    use HasFactory;
    
    protected $table = 'mark_register';

    static public function checkAlreadyMark($student_id,$exam_id,$class_id,$subject_id)
    {
        return self::where('student_id','=',$student_id)->where('exam_id','=',$exam_id)->where('class_id','=',$class_id)->where('subject_id','=',$subject_id)->first();
    }

    static public function getExamStudent($student_id)
    {
        return self::select('mark_register.*','exam.name as exam_name')
                    ->join('exam','exam.id','=','mark_register.exam_id')
                    ->where('mark_register.student_id','=',$student_id)
                    ->groupBy('mark_register.exam_id')
                    ->get();
    }

    static public function getExamSubject($exam_id,$student_id)
    {
        return self::select('mark_register.*','exam.name as exam_name','subject.name as subject_name')
                    ->join('exam','exam.id','=','mark_register.exam_id')
                    ->join('subject','subject.id','=','mark_register.subject_id')
                    ->where('mark_register.exam_id','=',$exam_id)
                    ->where('mark_register.student_id','=',$student_id)
                    ->get();
    }

    static public function getClass($exam_id,$student_id)
    {
        return self::select('mark_register.*','class.name as class_name')
                    ->join('exam','exam.id','=','mark_register.exam_id')
                    ->join('class','class.id','=','mark_register.class_id')
                    ->join('subject','subject.id','=','mark_register.subject_id')
                    ->where('mark_register.exam_id','=',$exam_id)
                    ->where('mark_register.student_id','=',$student_id)
                    ->first();
    }


    
}
