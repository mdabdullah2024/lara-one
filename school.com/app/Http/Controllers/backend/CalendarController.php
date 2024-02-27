<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\Week;
use App\Models\ClassSubjectTimetable;
use App\Models\SubjectModel;
use App\Models\ExamScheduleModel;
use App\Models\AssignClassTeacherModel;
use App\Models\User;
use Auth;

class CalendarController extends Controller
{
    public function MyCalendar()
    {
        
        $data['getMyTimetable'] = $this->getTimetable(Auth::user()->class_id);
        $data['getExamTimetable'] = $this->getExamTimetable(Auth::user()->class_id);
        $data['header_title'] = 'My Calendar';
        return view('backend.student.my_calendar.list',$data);
    }


    public function getExamTimetable($class_id)
    {
        $getExam = ExamScheduleModel::getExam($class_id);
        $result = array();
        foreach($getExam as $value)
        {
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $getExamTimetable = ExamScheduleModel::getExamTimetable($value->exam_id,$class_id);
            $resultS = array();
            foreach($getExamTimetable as $values )
            {
                $dataS = array();
                $dataS['subject_name'] = $values->subject_name;
                $dataS['exam_date'] = $values->exam_date;
                $dataS['start_time'] = $values->start_time;
                $dataS['end_time'] = $values->end_time;
                $dataS['room_number'] = $values->room_number;
                $dataS['passing_marks'] = $values->passing_marks;
                $dataS['full_marks'] = $values->full_marks;
                $resultS[] = $dataS;
            }
            $dataE['exam'] = $resultS;
            $result[] = $dataE;
        }
        return $result;
    }


    public function getTimetable($class_id)
    {
         $result = array();
        $getRecord = ClassSubjectModel::mySubject($class_id);
        foreach($getRecord as $value)
        {
            $dataS['name'] = $value->subject_name;
            $getWeek = Week::getRecord();
            $week = array();
            foreach($getWeek as $valueW)
            {
            $dataW = array();
            $dataW['week_id'] = $valueW->id;
            $dataW['week_name'] = $valueW->name;
            $dataW['full_calendar'] = $valueW->fullCalendar_day;
            $classSubject = ClassSubjectTimetable::getRecordClassSubject($value->class_id,$value->subject_id,$valueW->id);
                if (!empty($classSubject)) {
                    $dataW['start_time']=$classSubject->start_time;
                    $dataW['end_time']=$classSubject->end_time;
                    $dataW['room_number']=$classSubject->room_number;
                }else{
                    $dataW['start_time']='';
                    $dataW['end_time']='';
                    $dataW['room_number']='';
                }
            $week[] = $dataW;
            }
            $dataS['week'] = $week;
            $result[] = $dataS;
        }

        return $result;
    }


//parent side calendar
    public function myCalendarParent($student_id)
    {
        $getStudent = User::getSingle($student_id);
        $data['getMyTimetable'] = $this->getTimetable($getStudent->class_id);
        $data['getExamTimetable'] = $this->getExamTimetable($getStudent->class_id);
        $data['getStudent'] = $getStudent;
        $data['header_title'] = 'My Children Calendar';
        return view('backend.parent.my_children_calendar.list',$data);
    }

//teacher side
    public function MyCalendarTeacher()
    {
        $teacher_id = Auth::user()->id;
        $getTimetable = AssignClassTeacherModel::getTimetable($teacher_id);
        $getExamTimetable = ExamScheduleModel::getExamTimetableTeacher($teacher_id);
        $data['getTimetable'] = $getTimetable;
        $data['getExamTimetable'] = $getExamTimetable;
        $data['header_title'] = 'My Calendar';
        return view('backend.teacher.my_calendar.list',$data);
    }


}
