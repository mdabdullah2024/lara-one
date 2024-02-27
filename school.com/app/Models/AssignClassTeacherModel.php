<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\ClassModel;
use App\Models\class_subject;
use App\Models\Week;
use App\Models\SubjectModel;
use App\Models\AssignClassTeacherModel;
use App\Models\class_subject_timetable;
use Request;
class AssignClassTeacherModel extends Model
{
    use HasFactory;

    protected $table = 'assign_class_teacher';


    static function getRecord()
       {
        $return = self::select('assign_class_teacher.*','teacher.name as teacher_name','teacher.last_name as teacher_last_name','class.name as class_name','users.name as created_by_name')
                        ->join('users as teacher','teacher.id','=','assign_class_teacher.teacher_id','left')
                        ->join('class','class.id','=','assign_class_teacher.class_id','left')
                        ->join('users','users.id','=','assign_class_teacher.created_by','left')
                        ->where('assign_class_teacher.is_delete','=',0);
                        if (!empty(Request::get('class_name'))) {
                            $return = $return->where('class.name','like','%'.Request::get('class_name').'%');    
                        }
                        if (!empty(Request::get('teacher_name'))) {
                            $return = $return->where('teacher.name','like','%'.Request::get('teacher_name').'%');    
                        }
                        if (!empty(Request::get('teacher_last_name'))) {
                            $return = $return->where('teacher.last_name','like','%'.Request::get('teacher_last_name').'%');    
                        }
                        if (!empty(Request::get('status'))) {
                            $status = (Request::get('status')==100)?0:1;
                            $return = $return->where('assign_class_teacher.status','=',$status);    
                        }
                        if (!empty(Request::get('date'))) {
                            $return = $return->whereDate('assign_class_teacher.created_at','=',Request::get('date'));    
                        }
        $return = $return->orderBy('assign_class_teacher.id','desc')
                        ->paginate(20);
        return $return;
       }

    static function MySubjectClassCount($teacher_id)
    {
        $return = self::select('assign_class_teacher.id')
                        ->join('users as teacher','teacher.id','=','assign_class_teacher.teacher_id','left')
                        ->join('class','class.id','=','assign_class_teacher.class_id','left')
                        ->join('class_subject','class_subject.class_id','=','class.id')
                        ->join('subject','subject.id','=','class_subject.subject_id')
                        ->where('assign_class_teacher.is_delete','=',0)
                        ->where('subject.status','=',0)
                        ->where('subject.is_delete','=',0)
                        ->where('class_subject.status','=',0)
                        ->where('class_subject.is_delete','=',0)
                        ->where('assign_class_teacher.status','=',0)
                        ->where('assign_class_teacher.teacher_id','=',$teacher_id)
                        ->count();
            return $return;
    }
    static function MySubjectClass($teacher_id)
    {
        $return = self::select('assign_class_teacher.*','class.name as class_name','subject.name as subject_name','subject.type as subject_type','subject.id as subject_id','class.id as class_id')
                        ->join('users as teacher','teacher.id','=','assign_class_teacher.teacher_id','left')
                        ->join('class','class.id','=','assign_class_teacher.class_id','left')
                        ->join('class_subject','class_subject.class_id','=','class.id')
                        ->join('subject','subject.id','=','class_subject.subject_id')
                        ->where('assign_class_teacher.is_delete','=',0)
                        ->where('subject.status','=',0)
                        ->where('subject.is_delete','=',0)
                        ->where('class_subject.status','=',0)
                        ->where('class_subject.is_delete','=',0)
                        ->where('assign_class_teacher.status','=',0)
                        ->where('assign_class_teacher.teacher_id','=',$teacher_id)
                        ->get();
            return $return;
    }

    static function MySubjectClassGroup($teacher_id)
    {
        $return = self::select('assign_class_teacher.*','class.name as class_name','class.id as class_id')
                        ->join('class','class.id','=','assign_class_teacher.class_id','left')
                        ->where('assign_class_teacher.is_delete','=',0)
                        ->where('assign_class_teacher.status','=',0)
                        ->where('assign_class_teacher.teacher_id','=',$teacher_id)
                        ->groupBy('assign_class_teacher.class_id')
                        ->get();
            return $return;
    }

    static function getTeacherClassCount($teacher_id)
    {
        $return = self::select('assign_class_teacher.id')
                        ->join('class','class.id','=','assign_class_teacher.class_id','left')
                        ->where('assign_class_teacher.is_delete','=',0)
                        ->where('assign_class_teacher.status','=',0)
                        ->where('assign_class_teacher.teacher_id','=',$teacher_id)
                        ->count();
            return $return;
    }

    static public function getTimetable($teacher_id)
    {
        return AssignClassTeacherModel::select('class_subject_timetable.*','class.name as class_name','subject.name as subject_name','week.name as week_name','week.fullCalendar_day')
                    ->join('class','class.id','=','assign_class_teacher.class_id')
                    ->join('class_subject','class_subject.class_id','=','class.id')
                    ->join('class_subject_timetable','class_subject_timetable.subject_id','=','class_subject.subject_id')
                    ->join('subject','subject.id','=','class_subject_timetable.subject_id')
                    ->join('week','week.id','=','class_subject_timetable.week_id')
                    ->where('assign_class_teacher.teacher_id','=',$teacher_id)
                    ->where('assign_class_teacher.is_delete','=',0)
                        ->where('assign_class_teacher.status','=',0)
                    ->get();
    }

    static function getSingle($id)
    {
        return self::find($id);
    }

   
    static function getAlreadyFirst($class_id,$teacher_id)
   {
    return self::where('class_id','=',$class_id)->where('teacher_id','=',$teacher_id)->first();
   }

    static function getAssignClassTeacherID($class_id)
    {
        return  self::where('class_id','=',$class_id)
                        ->where('is_delete','=',0)
                        ->get();
    }

    static function deleteTeacher($class_id)
    {
        return self::where('class_id','=',$class_id)->delete();
    }

    static public function  getMyTimetable($class_id,$subject_id)
    {
        
        $getWeek = Week::getWeekUsingName(date('l'));
        
        return ClassSubjectTimetable::getRecordClassSubject($class_id,$subject_id,$getWeek->id);
    }

}
