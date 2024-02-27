<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\Week;
use App\Models\ClassSubjectTimetable;
use App\Models\SubjectModel;
use App\Models\User;
use Auth;

class ClassTimetableController extends Controller
{
     public function list(Request $request)
    {

        $data['header_title'] = 'Class Timetable';
        $data['getClass'] = ClassModel::getClass();
        $getRecord = Week::getRecord();
        $week = array();
        foreach($getRecord as $value)
        {
            $dataW = array();
            $dataW['week_id'] = $value->id;
            $dataW['week_name'] = $value->name;
            if (!empty($request->class_id) && !empty($request->subject_id)) {
                $classSubject = ClassSubjectTimetable::getRecordClassSubject($request->class_id,$request->subject_id,$value->id);
                if (!empty($classSubject)) {
                    $dataW['start_time']=$classSubject->start_time;
                    $dataW['end_time']=$classSubject->end_time;
                    $dataW['room_number']=$classSubject->room_number;
                }else{
                    $dataW['start_time']='';
                    $dataW['end_time']='';
                    $dataW['room_number']='';
                }
            }else{
                $dataW['start_time']='';
                    $dataW['end_time']='';
                    $dataW['room_number']='';
            }
            $week[] = $dataW;

        }
            $data['week'] = $week;
        if (!empty($request->class_id)) {
        $data['getSubject'] = ClassSubjectModel::mySubject($request->class_id);
            
        }

        return view('backend.admin.class_timetable.list',$data);
    }

    public function getSubject(Request $request)
    {
        $getSubject = ClassSubjectModel::mySubject($request->class_id);

        $html ='<option value="">Select</option>';
        foreach ($getSubject as $key => $value) {
        $html .='<option value="'.$value->subject_id.'">'.$value->subject_name.'</option>';
        }
        $json['html'] = $html;
        echo json_encode($json);
    }


    public function storeUpdate(Request $request)
    {
        ClassSubjectTimetable::where('class_id','=',$request->class_id)->where('subject_id','=',$request->subject_id)->delete();
        foreach ($request->timetable as $value) {
            if (!empty($value['week_id'])  && !empty($value['start_time']) && !empty($value['end_time']) && !empty($value['room_number']) ) {
               $save = new ClassSubjectTimetable();
               $save->class_id = $request->class_id;
               $save->subject_id = $request->subject_id;
               $save->week_id = $value['week_id'];
               $save->start_time = $value['start_time'];
               $save->end_time = $value['end_time'];
               $save->room_number = $value['room_number'];
               $save->save();
            }
        }

        return redirect()->back()->with('success','Class Timetable successfully created.');
    }


//student side timetable
    public function MyTimetable()
    {
        $result = array();
        $getRecord = ClassSubjectModel::mySubject(Auth::user()->class_id);
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
        $data['getRecord']=$result;
        $data['header_title'] = 'My Class Timetable';
        return view('backend.student.my_timetable.list',$data);
    }
//teacher side function
    public function MyTimetableTeacher($class_id,$subject_id)
    {
            $data['getClass'] = ClassModel::getSingle($class_id);
            $data['getSubject'] = SubjectModel::getSingle($subject_id);
            $week = array();
            $getWeek = Week::getRecord();
            foreach($getWeek as $valueW)
            {
            $dataW = array();
            $dataW['week_id'] = $valueW->id;
            $dataW['week_name'] = $valueW->name;
            $classSubject = ClassSubjectTimetable::getRecordClassSubject($class_id,$subject_id,$valueW->id);
                if (!empty($classSubject)) {
                    $dataW['start_time']=$classSubject->start_time;
                    $dataW['end_time']=$classSubject->end_time;
                    $dataW['room_number']=$classSubject->room_number;
                }else{
                    $dataW['start_time']='';
                    $dataW['end_time']='';
                    $dataW['room_number']='';
                }
            $result[] = $dataW;
            }
        $data['getRecord']=$result;
        $data['header_title'] = 'My Class Timetable';
        return view('backend.teacher.my_timetable.list',$data);
    }

    public function myChildrenClassTimetable($class_id,$subject_id,$student_id)
    {
        $data['getClass'] = ClassModel::getSingle($class_id);
            $data['getSubject'] = SubjectModel::getSingle($subject_id);
            $data['getUser'] = User::getSingle($student_id);
            $week = array();
            $getWeek = Week::getRecord();
            foreach($getWeek as $valueW)
            {
            $dataW = array();
            $dataW['week_id'] = $valueW->id;
            $dataW['week_name'] = $valueW->name;
            $classSubject = ClassSubjectTimetable::getRecordClassSubject($class_id,$subject_id,$valueW->id);
                if (!empty($classSubject)) {
                    $dataW['start_time']=$classSubject->start_time;
                    $dataW['end_time']=$classSubject->end_time;
                    $dataW['room_number']=$classSubject->room_number;
                }else{
                    $dataW['start_time']='';
                    $dataW['end_time']='';
                    $dataW['room_number']='';
                }
            $result[] = $dataW;
            }
        $data['getRecord']=$result;
        $data['header_title'] = 'My Class Timetable';
        return view('backend.parent.my_timetable.list',$data);
    }




}
