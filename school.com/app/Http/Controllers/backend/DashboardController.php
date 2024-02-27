<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\StudentAddFeesModel;
use App\Models\ExamModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\AssignClassTeacherModel;
use App\Models\NoticeBoardModel;
use App\Models\ClassSubjectModel;
use App\Models\HomeworkModel;
use App\Models\HomeworkSubmitModel;
use App\Models\StudentAttendanceModel;

class DashboardController extends Controller
{
    
    public function dashboard()
    {
        $data['header_title'] = 'Dashboard';

        if (Auth::user()->user_type==1) {
            
            $data['TotalFeesReceived'] = StudentAddFeesModel::TotalFeesReceived();
            $data['todayTotalPayment'] = StudentAddFeesModel::todayTotalPayment();
            $data['totalAdmin'] = User::TotalUser(1);
            $data['totalTeacher'] = User::TotalUser(2);
            $data['totalStudent'] = User::TotalUser(3);
            $data['totalParent'] = User::TotalUser(4);
            $data['totalExam']  = ExamModel::getTotalExam();
            $data['totalClass']  = ClassModel::totalClass();
            $data['totalSubject']  = SubjectModel::totalSubject();

            return view('backend.admin.dashboard',$data);
        }
        else if (Auth::user()->user_type==2) {
            $data['totalStudent'] = User::getStudentoOfTeacherCount(Auth::user()->id);
            $data['notice_board_count'] = NoticeBoardModel::getRecordUserCount(Auth::user()->id);
            $data['getTeacherClassCount'] = AssignClassTeacherModel::getTeacherClassCount(Auth::user()->id);
            $data['MySubjectClassCount'] = AssignClassTeacherModel::MySubjectClassCount(Auth::user()->id);
            $id = Auth::User()->id;
            $data['getRecord'] = User::getSingle($id);
            return view('backend.teacher.dashboard',$data);
        }
        else if (Auth::user()->user_type==3) {
            $data['TotalPaidAmounts'] = StudentAddFeesModel::TotalPaidAmounts(Auth::user()->id);
            $data['totalStudent'] = User::TotalUser(3);
            $data['getClass']  = User::getStudentClassSingle(Auth::user()->class_id);
            $data['StudentTotalSubjects']  = ClassSubjectModel::StudentTotalSubjects(Auth::user()->class_id);
            $data['notice_board_count'] = NoticeBoardModel::getRecordUserCount(Auth::user()->id);
            $data['getRecordStudentCount'] = HomeworkModel::getRecordStudentCount(Auth::user()->id,Auth::user()->class_id);
            $data['SubmittedHomeworkCount'] = HomeworkSubmitModel::SubmittedHomeworkCount(Auth::user()->id);
            $data['TotalMyAttendanceCount'] = StudentAttendanceModel::TotalMyAttendanceCount(Auth::user()->id);

            return view('backend.student.dashboard',$data);
        }
        else if (Auth::user()->user_type==4) {

            $student_ids = User::getMyStudentIds(Auth::user()->id);

            if (!empty($student_ids)) {
                $data['TotalMyChildPayment'] = StudentAddFeesModel::TotalMyChildPaymentParent($student_ids);
            $data['TotalMyChildAttendanceCount'] = StudentAttendanceModel::TotalMyChildAttendanceCount($student_ids);
            $data['SubmittedHomeworkParentCount'] = HomeworkSubmitModel::SubmittedMyChildHomeworkCount($student_ids);


            }else{
                $data['TotalMyChildPayment'] = 0;
                $data['TotalMyAttendanceCount'] = 0;
                $data['SubmittedHomeworkParentCount'] =0;
            }


            $data['getMyStudentCount'] = User::getMyStudentCount(Auth::user()->id);
            $data['NoticeboardParentCount'] = NoticeBoardModel::NoticeboardParentCount(Auth::user()->user_type);
            
            return view('backend.parent.dashboard',$data);
        }
    }
}
