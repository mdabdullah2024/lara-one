<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class HomeworkSubmitModel extends Model
{
    use HasFactory;
    protected $table = 'homework_submit';

    static public function getRecordReports()
    {
        $return = self::select('homework_submit.*','class.name as class_name','subject.name as subject_name','users.name as student_firstName','users.last_name as student_lastName')
                        ->join('homework','homework.id','=','homework_submit.homework_id')
                        ->join('class','class.id','=','homework.class_id')
                        ->join('subject','subject.id','=','homework.subject_id')
                        ->join('users','users.id','=','homework_submit.student_id');
                        if (!empty(Request::get('first_name'))) {
                          $return = $return->where('users.name','like','%'.Request::get('first_name').'%');
                        }
                        if (!empty(Request::get('last_name'))) {
                          $return = $return->where('users.last_name','like','%'.Request::get('last_name').'%');
                        }
                        if (!empty(Request::get('class_name'))) {
                          $return = $return->where('class.name','like','%'.Request::get('class_name').'%');
                        }
                        if (!empty(Request::get('subject_name'))) {
                          $return = $return->where('subject.name','like','%'.Request::get('subject_name').'%');
                        }
                        if (!empty(Request::get('from_homework_date'))) {
                          $return = $return->where('homework.homework_date','>=',Request::get('from_homework_date'));
                        }
                        if (!empty(Request::get('to_homework_date'))) {
                          $return = $return->where('homework.homework_date','<=',Request::get('to_homework_date'));
                        }


                        if (!empty(Request::get('from_submission_date'))) {
                          $return = $return->where('homework.submission_date','>=',Request::get('from_submission_date'));
                        }
                        if (!empty(Request::get('to_submission_date'))) {
                          $return = $return->where('homework.submission_date','<=',Request::get('to_submission_date'));
                        }

                        if (!empty(Request::get('from_created_date'))) {
                          $return = $return->whereDate('homework.created_at','>=',Request::get('from_created_date'));
                        }
                        if (!empty(Request::get('to_created_date'))) {
                          $return = $return->whereDate('homework.created_at','<=',Request::get('to_created_date'));
                        }
                        if (!empty(Request::get('from_submitted_created_date'))) {
                          $return = $return->whereDate('homework_submit.created_at','>=',Request::get('from_submitted_created_date'));
                        }
                        if (!empty(Request::get('to_submitted_created_date'))) {
                          $return = $return->whereDate('homework_submit.created_at','<=',Request::get('to_submitted_created_date'));
                        }
        $return = $return->orderBy('homework_submit.id','desc')
                        ->paginate(20);
        return $return;

    }

    static public function getRecord($homework_id)
    {
      $return = self::select('homework_submit.*','users.name as users_name','users.last_name as user_lastname')
                      ->join('users','users.id','=','homework_submit.student_id')
                      ->where('homework_submit.homework_id','=',$homework_id);
                      if (!empty(Request::get('student_firstName'))) {
                          $return = $return->where('users.name','like','%'.Request::get('student_firstName').'%');
                      }
                      if (!empty(Request::get('student_lastName'))) {
                          $return = $return->where('users.last_name','like','%'.Request::get('student_lastName').'%');
                      }
                      if (!empty(Request::get('from_created_date'))) {
                          $return = $return->whereDate('homework_submit.created_at','>=',Request::get('from_created_date'));
                      }
                      if (!empty(Request::get('to_created_date'))) {
                        $return = $return->whereDate('homework_submit.created_at','<=',Request::get('to_created_date'));
                      }
      $return=$return->orderBy('homework_submit.id','desc')
                      ->paginate(50);
      return $return;
    }



    static public function getSubmittedStudentHomework($student_id)
    {
        $return = self::select('homework_submit.*','class.name as class_name','subject.name as subject_name')
                        ->join('homework','homework.id','=','homework_submit.homework_id')
                        ->join('class','class.id','=','homework.class_id')
                        ->join('subject','subject.id','=','homework.subject_id')
                        ->where('homework_submit.student_id','=',$student_id);
                        if (!empty(Request::get('class_name'))) {
                          $return = $return->where('class.name','like','%'.Request::get('class_name').'%');
                        }
                        if (!empty(Request::get('subject_name'))) {
                          $return = $return->where('subject.name','like','%'.Request::get('subject_name').'%');
                        }
                        if (!empty(Request::get('from_homework_date'))) {
                          $return = $return->where('homework.homework_date','>=',Request::get('from_homework_date'));
                        }
                        if (!empty(Request::get('to_homework_date'))) {
                          $return = $return->where('homework.homework_date','<=',Request::get('to_homework_date'));
                        }


                        if (!empty(Request::get('from_submission_date'))) {
                          $return = $return->where('homework.submission_date','>=',Request::get('from_submission_date'));
                        }
                        if (!empty(Request::get('to_submission_date'))) {
                          $return = $return->where('homework.submission_date','<=',Request::get('to_submission_date'));
                        }

                        if (!empty(Request::get('from_created_date'))) {
                          $return = $return->whereDate('homework.created_at','>=',Request::get('from_created_date'));
                        }
                        if (!empty(Request::get('to_created_date'))) {
                          $return = $return->whereDate('homework.created_at','<=',Request::get('to_created_date'));
                        }
                        if (!empty(Request::get('from_submitted_created_date'))) {
                          $return = $return->whereDate('homework_submit.created_at','>=',Request::get('from_submitted_created_date'));
                        }
                        if (!empty(Request::get('to_submitted_created_date'))) {
                          $return = $return->whereDate('homework_submit.created_at','<=',Request::get('to_submitted_created_date'));
                        }
       $return = $return->orderBy('homework_submit.id','desc')
                        ->paginate(20);
        return $return;
    }

    static public function SubmittedHomeworkCount($student_id)
    {
        $return = self::select('homework_submit.id','class.name as class_name','subject.name as subject_name')
                        ->join('homework','homework.id','=','homework_submit.homework_id')
                        ->join('class','class.id','=','homework.class_id')
                        ->join('subject','subject.id','=','homework.subject_id')
                        ->where('homework_submit.student_id','=',$student_id);
                        
       $return = $return->count();
        return $return;
    }
    static public function SubmittedMyChildHomeworkCount($student_ids)
    {
        $return = self::select('homework_submit.id','class.name as class_name','subject.name as subject_name')
                        ->join('homework','homework.id','=','homework_submit.homework_id')
                        ->join('class','class.id','=','homework.class_id')
                        ->join('subject','subject.id','=','homework.subject_id')
                        ->whereIn('homework_submit.student_id',$student_ids);
                        
       $return = $return->count();
        return $return;
    }


    
    public function getHomework()
    {
        return $this->belongsTo(HomeworkModel::class,"homework_id");
    }

    public function getStudent()
    {
        return $this->belongsTo(User::class,"student_id");
    }

    public function getDocument()
    {
        if (!empty($this->document_file) && file_exists('public/upload/homework/'.$this->document_file)) {
            return url('public/upload/homework/'.$this->document_file);

        }else{
            return "";
        }
    }
}
