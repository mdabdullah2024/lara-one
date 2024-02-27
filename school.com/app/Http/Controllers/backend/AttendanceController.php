<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\AssignClassTeacherModel;
use Auth;
use App\Models\StudentAttendanceModel;
class AttendanceController extends Controller
{
    public function StudentAttendance(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        if (!empty($request->get('class_id')) && !empty($request->get('attendance_date'))) {
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }
        $data['header_title'] = 'Student Attendance';
        return view('backend.admin.attendance.student_attendance',$data);
    }

    public function StudentAttendanceSave(Request $request)
    {
        $check_attendance = StudentAttendanceModel::checkAlreadyAttendance($request->student_id,$request->class_id,$request->attendance_date);
        if (!empty($check_attendance)) {
            $save = $check_attendance;
        }
        else
        {
            $save = new StudentAttendanceModel();
            $save->class_id = trim($request->class_id);
            $save->student_id = trim($request->student_id);
            $save->attendance_date = trim($request->attendance_date);
            $save->created_by = Auth::user()->id;
        }
        
        $save->attendance_type = trim($request->attendance_type);
        $save->save();
        $json['message'] = "Attendance Successfully Saved";
        echo json_encode($json);
    }

//Attendance Reports
    public function StudentAttendanceReports(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getRecord'] = StudentAttendanceModel::getRecord();
        $data['header_title'] = 'Attendance Reports';
        return view('backend.admin.attendance.attendance_reports',$data);
    }

//teacher side attendance 
    public function StudentAttendanceTeacher(Request $request)
    {
        $data['getClass'] = AssignClassTeacherModel::MySubjectClassGroup(Auth::user()->id);
        if (!empty($request->get('class_id')) && !empty($request->get('attendance_date'))) {
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }
        $data['header_title'] = 'Student Attendance';
        return view('backend.teacher.attendance.student_attendance',$data);
    }
    public function StudentAttendanceTeacherSave(Request $request)
    {
        $check_attendance = StudentAttendanceModel::checkAlreadyAttendance($request->student_id,$request->class_id,$request->attendance_date);
        if (!empty($check_attendance)) {
            $save = $check_attendance;
        }
        else
        {
            $save = new StudentAttendanceModel();
            $save->class_id = trim($request->class_id);
            $save->student_id = trim($request->student_id);
            $save->attendance_date = trim($request->attendance_date);
            $save->created_by = Auth::user()->id;
        }
        
        $save->attendance_type = trim($request->attendance_type);
        $save->save();
        $json['message'] = "Attendance Successfully Saved";
        echo json_encode($json);
    }
    public function StudentAttendanceTeacherReport(Request $request)
    {
        $data['getClass'] = AssignClassTeacherModel::MySubjectClassGroup(Auth::user()->id);
        $data['getRecord'] = StudentAttendanceModel::getRecord();
        
        $data['header_title'] = 'Student Attendance Reports';
        return view('backend.teacher.attendance.student_attendance_reports',$data);
    }
    
//student side my attendance
public function myAttendanceReports()
{
    $data['getClass'] = StudentAttendanceModel::getMyClass(Auth::user()->id);
    $data['getRecord'] = StudentAttendanceModel::getRecordStudent(Auth::user()->id);
    $data['header_title'] = 'My Attendance';
    return view('backend.student.attendance.myattendance',$data);
}
//parent side child attendance
public function myChildrenAttendance($student_id)
{
    $data['getChild'] = User::getSingle($student_id);
   $data['getClass'] = StudentAttendanceModel::getMyClass($student_id);
    $data['getRecord'] = StudentAttendanceModel::getRecordStudent($student_id);
    $data['header_title'] = 'My Child Attendance';
    return view('backend.parent.attendance.my_child_attendance',$data); 
}

}
