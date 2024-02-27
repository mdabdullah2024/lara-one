<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamScheduleModel;
use App\Models\AssignClassTeacherModel;
use App\Models\MarkRegisterModel;
use App\Models\MarksGradeModel;
use App\Models\SettingsModel;
use App\Models\User;
use Auth;
class ExaminationController extends Controller
{
    public function Examlist()
    {
        $data['getRecord'] = ExamModel::getRecord();
        $data['header_title'] = 'Exam list';
        return view('backend.admin.examinations.list',$data);
    }

    public function add()
    {
        
        $data['header_title'] = 'Exam Add';
        return view('backend.admin.examinations.add',$data);
    }

    public function store(Request $request)
    {
       $exam = new ExamModel();
       $exam->name = trim($request->name);
       $exam->note = trim($request->note);
       $exam->created_by = Auth::user()->id;
       $exam->save();

       return redirect('admin/examinations/exam/list')->with('success','Exam Successfully Created.');
    }

    public function edit($id)
    {
        $data['getRecord'] = ExamModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Exam Edit';
            return view('backend.admin.examinations.edit',$data);
        }else{
            abort(404);
        }
        
    }

    public function update(Request $request,$id)
    {
       $exam =  ExamModel::getSingle($id);
       $exam->name = trim($request->name);
       $exam->note = trim($request->note);
       $exam->created_by = Auth::user()->id;
       $exam->save();

       return redirect('admin/examinations/exam/list')->with('success','Exam Successfully updated.');
    }

     public function delete($id)
    {
       $exam =  ExamModel::getSingle($id);
       if (!empty($exam)) {
           $exam->is_delete = 1;
           $exam->save();
           return redirect('admin/examinations/exam/list')->with('success','Exam Successfully deleted.');

       }else{
        abort(404);
       }
    }

//Exam Mark Register
    public function examMarkRegister(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();
        $data['header_title'] = 'Mark Register';
        if ( !empty($request->get('exam_id')) && !empty($request->get('class_id')) )
        {

            $data['getSubject'] = ExamScheduleModel::getSubject($request->get('exam_id'), $request->get('class_id'));
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }
        return view('backend.admin.examinations.mark_register',$data);
    }
//exam mark grade
    public function examMarkGradeList()
    {
        $data['getRecord']  = MarksGradeModel::getRecord();
        $data['header_title'] = 'Exam Marks Grade';
        return view('backend.admin.examinations.Marks_Grade.list',$data);
    }

    public function examMarkGradeAdd()
    {
        
        $data['header_title'] = 'Add Exam Marks Grade';
        return view('backend.admin.examinations.Marks_Grade.add',$data);
    }

    public function examMarkGradeStore(Request $request)
    {
        $marksGrade = new MarksGradeModel();
        $marksGrade->name = trim($request->name);
        $marksGrade->percent_from = trim($request->percent_from);
        $marksGrade->percent_to = trim($request->percent_to);
        $marksGrade->created_by = Auth::user()->id;
        $marksGrade->save();

        return redirect('/admin/examinations/mark_grade/list')->with('success','Marks Grade Successfully saved.');
    }
    public function examMarkGradeEdit($id)
    {
        $data['getRecord'] = MarksGradeModel::getSingle($id);
        $data['header_title'] = 'Edit Exam Marks Grade';
        return view('backend.admin.examinations.Marks_Grade.edit',$data);
    }

    public function examMarkGradeUpdate(Request $request,$id)
    {
        $marksGrade = MarksGradeModel::getSingle($id);
        $marksGrade->name = trim($request->name);
        $marksGrade->percent_from = trim($request->percent_from);
        $marksGrade->percent_to = trim($request->percent_to);
        $marksGrade->created_by = Auth::user()->id;
        $marksGrade->save();

        return redirect('/admin/examinations/mark_grade/list')->with('success','Marks Grade Successfully Updated .');
    }

    public function examMarkGradeDelete($id)
    {
        $marksGrade = MarksGradeModel::getSingle($id);
        $marksGrade->delete();

        return redirect('/admin/examinations/mark_grade/list')->with('success','Marks Grade Successfully Deleted.');
    }

//teacher side mark register

    public function marksRegisterTeacher(Request $request)
    {
        // dd($request->all());
        $data['getClass'] = AssignClassTeacherModel::MySubjectClassGroup(Auth::User()->id);
        $data['getExam'] = ExamScheduleModel::getExamTeacher(Auth::User()->id);
        
        $data['header_title'] = 'Mark Register';
        if ( !empty($request->get('exam_id')) && !empty($request->get('class_id')) )
        {

            $data['getSubject'] = ExamScheduleModel::getSubject($request->get('exam_id'), $request->get('class_id'));
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }
        return view('backend.teacher.examinations.mark_register',$data);
    }


    public function examMarkRegisterSubmit(Request $request)
    {
        
        $validation = 0;
       if (!empty($request->mark)) {

           foreach ($request->mark as $mark) {

               $getExamScheduleModel = ExamScheduleModel::getSingle($mark['id']);

               $full_marks = $getExamScheduleModel->full_marks;

               $class_work = !empty($mark['class_work'])?$mark['class_work']:0 ;
               $home_work = !empty($mark['home_work'])?$mark['home_work']:0 ;
               $test_work = !empty($mark['test_work'])?$mark['test_work']:0 ;
               $exam = !empty($mark['exam'])?$mark['exam']:0 ;
               $full_marks = !empty($mark['full_marks'])?$mark['full_marks']:0 ;
               $passing_marks = !empty($mark['passing_marks'])?$mark['passing_marks']:0 ;

              $total_marks = $class_work + $home_work + $test_work + $exam;


              if ($full_marks >= $total_marks) {

                   $getMark = MarkRegisterModel::checkAlreadyMark($request->student_id,$request->exam_id,$request->class_id,$mark['subject_id']);

                   if (!empty($getMark)) {
                       $save = $getMark;
                   }else{
                    $save = new MarkRegisterModel;
                    $save->created_by = Auth::user()->id;
                   }

                   $save->student_id = $request->student_id;
                   $save->exam_id = $request->exam_id;
                   $save->class_id = $request->class_id;
                   $save->subject_id = $mark['subject_id'];
                   $save->class_work = $class_work;
                   $save->home_work = $home_work;
                   $save->test_work = $test_work;
                   $save->exam = $exam;
                   $save->full_marks = $full_marks;
                   $save->passing_marks = $passing_marks;
                   $save->save();
                }
                else
                {
                    $validation = 1;
                }
           }
       }

       if ($validation==0) {
            $json['message'] = 'Marks Successfully Saved.';
       }
       else
       {
            $json['message'] = 'Marks Successfully Saved but Some subject Marks greater than Full Marks.';

       }
        echo json_encode($json);
    }

    public function examMarkRegisterSubmitSingle(Request $request)
    {
        
        $id = $request->id;
        $getExamScheduleModel = ExamScheduleModel::getSingle($id);

        $full_marks = $getExamScheduleModel->full_marks;

        $class_work = !empty($request->class_work)?$request->class_work:0 ;
        $home_work = !empty($request->home_work)?$request->home_work:0 ;
        $test_work = !empty($request->test_work)?$request->test_work:0 ;
        $exam = !empty($request->exam)?$request->exam:0 ;
        $full_marks = !empty($request->full_marks)?$request->full_marks:0 ;
        $passing_marks = !empty($request->passing_marks)?$request->passing_marks:0 ;

        $total_marks = $class_work + $home_work + $test_work + $exam;

        if ($full_marks >= $total_marks) {
           $getMark = MarkRegisterModel::checkAlreadyMark($request->student_id,$request->exam_id,$request->class_id,$request->subject_id);

               if (!empty($getMark)) {
                   $save = $getMark;
               }else{
                $save = new MarkRegisterModel;
                $save->created_by = Auth::user()->id;
               }

               $save->student_id = $request->student_id;
               $save->exam_id = $request->exam_id;
               $save->class_id = $request->class_id;
               $save->subject_id = $request->subject_id;
               $save->class_work = $request->class_work;
               $save->home_work = $request->home_work;
               $save->test_work = $request->test_work;
               $save->exam = $request->exam;
               $save->full_marks = $request->full_marks;
               $save->passing_marks = $request->passing_marks;
               $save->save();

               $json['message'] = 'Marks Successfully Saved.';
        }else{
               $json['message'] = 'Your input marks greater than full Marks';

        }

        
               echo json_encode($json);
    }

//Exam Schedule Methods

    public function examSchedulelist(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();
        $result = array();
        if ( !empty($request->get('exam_id')) && !empty($request->get('class_id')) ) {
           $getSubject = ClassSubjectModel::mySubject($request->get('class_id'));
           foreach($getSubject as $value){
            $dataS = array();
            $dataS['subject_id'] = $value->subject_id;
            $dataS['class_id'] = $value->class_id;
            $dataS['subject_name'] = $value->subject_name;
            $dataS['subject_type'] = $value->subject_type;

            $examSchedule = ExamScheduleModel::getRecordSingle($request->get('exam_id'),$request->get('class_id'),$value->subject_id);
            if (!empty($examSchedule)) {
                $dataS['exam_date'] = $examSchedule->exam_date;
                $dataS['start_time'] = $examSchedule->start_time;
                $dataS['end_time'] = $examSchedule->end_time;
                $dataS['room_number'] = $examSchedule->room_number;
                $dataS['full_marks'] = $examSchedule->full_marks;
                $dataS['passing_marks'] = $examSchedule->passing_marks;
            }else{
                $dataS['exam_date'] = '';
                $dataS['start_time'] = '';
                $dataS['end_time'] = '';
                $dataS['room_number'] = '';
                $dataS['full_marks'] = '';
                $dataS['passing_marks'] = '';

            }
            $result[] = $dataS;
           }

        }
        $data['getRecord'] = $result;
        $data['header_title'] = 'Exam Schedule';
        return view('backend.admin.examinations.exam_schedule',$data);
    }

    public function examSchedulelistInsert(Request $request)
    {
        ExamScheduleModel::getDeleteRecord($request->exam_id,$request->class_id);
       if (!empty($request->schedule)) {
            foreach($request->schedule as $schedule)
           {
            if (!empty($schedule['subject_id']) && !empty($schedule['exam_date']) && !empty($schedule['start_time']) && !empty($schedule['end_time']) && !empty($schedule['room_number']) && !empty($schedule['full_marks']) && !empty($schedule['passing_marks'])) {
                $exam = new ExamScheduleModel();
                $exam->exam_id = $request->exam_id;
                $exam->class_id = $request->class_id;
                $exam->subject_id = $schedule['subject_id'];
                $exam->exam_date = $schedule['exam_date'];
                $exam->start_time = $schedule['start_time'];
                $exam->end_time = $schedule['end_time'];
                $exam->room_number = $schedule['room_number'];
                $exam->full_marks = $schedule['full_marks'];
                $exam->passing_marks = $schedule['passing_marks'];
                $exam->created_by = Auth::user()->id;
                $exam->save();
            }
           }

           return redirect()->back()->with('success','Exam Schedule Successfully saved.');
       }
    }
//student side exam result
    public function myExamResultPrint(Request $request)
    {
        $exam_id = $request->exam_id;
        $student_id = $request->student_id;

        $data['getSetting'] = SettingsModel::getSingle();
        $data['getExam'] = ExamModel::getSingle($exam_id);
        $data['getStudent'] = User::getSingle($student_id);
        $getExamSubject = MarkRegisterModel::getExamSubject($exam_id,$student_id);
        $data['getClass'] = MarkRegisterModel::getClass($exam_id,$student_id);
            $dataSubject = array();
            foreach ($getExamSubject as $exam) {
                $obtain_marks = $exam['class_work'] + $exam['test_work'] + $exam['home_work'] + $exam['exam'];
                $dataS = array();
                $dataS['subject_name'] = $exam['subject_name'];
                $dataS['class_work'] = $exam['class_work'];
                $dataS['test_work'] = $exam['test_work'];
                $dataS['home_work'] = $exam['home_work'];
                $dataS['exam'] = $exam['exam'];
                $dataS['obtain_marks'] = $obtain_marks;
                $dataS['full_marks'] = $exam['full_marks'];
                $dataS['passing_marks'] = $exam['passing_marks'];
                $dataSubject[] = $dataS;
            }
            $data['getExamMark'] = $dataSubject;
        return view('backend.exam_result_print',$data);
    }
    public function myExamResult(Request $request)
    {
        // dd('ok'); 
        $getExam = MarkRegisterModel::getExamStudent(Auth::user()->id);
        $result = array();
        foreach($getExam as $value)
        {
            $dataE = array();
            $dataE['exam_name'] = $value->exam_name;
            $dataE['exam_id'] = $value->exam_id;
            $getExamSubject = MarkRegisterModel::getExamSubject($value->exam_id,Auth::user()->id);
            $dataSubject = array();
            foreach ($getExamSubject as $exam) {
                $obtain_marks = $exam['class_work'] + $exam['test_work'] + $exam['home_work'] + $exam['exam'];
                $dataS = array();
                $dataS['subject_name'] = $exam['subject_name'];
                $dataS['class_work'] = $exam['class_work'];
                $dataS['test_work'] = $exam['test_work'];
                $dataS['home_work'] = $exam['home_work'];
                $dataS['exam'] = $exam['exam'];
                $dataS['obtain_marks'] = $obtain_marks;
                $dataS['full_marks'] = $exam['full_marks'];
                $dataS['passing_marks'] = $exam['passing_marks'];
                $dataSubject[] = $dataS;
            }
            $dataE['subject'] = $dataSubject;
            $result[] = $dataE;
        }
        $data['getRecord'] = $result;
        $data['header_title'] = 'My Exam Result';
        return view('backend.student.examResult.my_exam_result',$data);
    }
//student side exam timetable
       
    public function MyExamTimetable()
    {
        $class_id = Auth::User()->class_id;
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
        $data['getRecord'] = $result;
        $data['header_title'] = 'My Exam Timetable';
        return view('backend.student.my_exam_timetable.list',$data);
    }
//teacher side exam timetable
    public function MyExamTimetableTeacher()
    {

        $result = array(); 
        $getClass = AssignClassTeacherModel::MySubjectClassGroup(Auth::User()->id);
        foreach($getClass as $class)
        {
            $dataC = array();
            $dataC['class_name'] =$class->class_name;
            $getExam = ExamScheduleModel::getExam($class->class_id);
            $resultE = array();
            foreach($getExam as $valueE)
            {
                $dataE['exam_name'] = $valueE->exam_name;
                $getExamTimetable = ExamScheduleModel::getExamTimetable($valueE->exam_id,$class->class_id);
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
                $dataE['subject'] = $resultS;
                $resultE[]=$dataE;
            }
            $dataC['exam'] = $resultE;
            $result[] = $dataC;
        }
        $data['getRecord'] = $result;
        $data['header_title'] = 'My Exam Timetable';
        return view('backend.teacher.my_exam_timetable.list',$data);
    }

//parent side exam result
    public function myChildrenExamResult(Request $request, $student_id)
    {
        $data['getStudent'] = User::getSingle($student_id);
        $getExam = MarkRegisterModel::getExamStudent($student_id);
        $result = array();
        foreach($getExam as $value)
        {
            $dataE = array();
            $dataE['exam_name'] = $value->exam_name;
            $dataE['exam_id'] = $value->exam_id;
            $getExamSubject = MarkRegisterModel::getExamSubject($value->exam_id,$student_id);
            $dataSubject = array();
            foreach ($getExamSubject as $exam) {
                $obtain_marks = $exam['class_work'] + $exam['test_work'] + $exam['home_work'] + $exam['exam'];
                $dataS = array();
                $dataS['subject_name'] = $exam['subject_name'];
                $dataS['class_work'] = $exam['class_work'];
                $dataS['test_work'] = $exam['test_work'];
                $dataS['home_work'] = $exam['home_work'];
                $dataS['exam'] = $exam['exam'];
                $dataS['obtain_marks'] = $obtain_marks;
                $dataS['full_marks'] = $exam['full_marks'];
                $dataS['passing_marks'] = $exam['passing_marks'];
                $dataSubject[] = $dataS;
            }
            $dataE['subject'] = $dataSubject;
            $result[] = $dataE;
        }
        $data['getRecord'] = $result;
        $data['header_title'] = 'Child Exam Result';
        return view('backend.parent.examResult.my_exam_result',$data);
    }
//parent side method
public function myChildrenExamTimetable($student_id)
{
    $getStudent = User::getSingle($student_id);
    $class_id = $getStudent->class_id;
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
        $data['getStudent'] = $getStudent;
        $data['getRecord'] = $result;
        $data['header_title'] = 'Exam Timetable';
        return view('backend.parent.my_exam_timetable.list',$data);
}



}
