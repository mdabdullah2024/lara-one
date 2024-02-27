<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\ClassSubjectModel;
use App\Models\HomeworkModel;
use App\Models\HomeworkSubmitModel;
use App\Models\AssignClassTeacherModel;
use App\Models\User;
use Auth;

class HomeworkController extends Controller
{
    public function HomeworkReports()
    {
        $data['getRecord'] = HomeworkSubmitModel::getRecordReports();
        $data['header_title'] = 'Homework Reports';
        return view('backend.admin.Homework.report',$data);
    }
    public function Homework()
    {
        $data['getRecord'] = HomeworkModel::getRecord();
        $data['header_title'] = 'Homework';
        return view('backend.admin.Homework.list',$data);
    }

    public function HomeworkAdd()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['header_title'] = 'Add New Homework';
        return view('backend.admin.Homework.add',$data);
    }

    public function AjaxGetSubject(Request $request)
    {
        $class_id = $request->class_id;
        $getSubject =  ClassSubjectModel::mySubject($class_id);
        $html = '';
        $html .= '<option value="">Select Subject</option>';
        foreach ($getSubject as  $value) {
        $html .= '<option value="'.$value->subject_id.'">'.$value->subject_name.'</option'.'<br>';
        }
        $json['success'] = $html;
        echo json_encode($json);
    }

    public function InsertHomework(Request $request)
    {
        $homework = new HomeworkModel();
        $homework->class_id = trim($request->class_id);
        $homework->subject_id = trim($request->subject_id);
        $homework->homework_date = trim($request->homework_date);
        $homework->submission_date = trim($request->submission_date);
        $homework->description = trim($request->description);
        $homework->created_by = Auth::user()->id;
        if (!empty($request->file('document_file'))) {
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $random = date('mdYHs').uniqid();
            $filename =$random.'.'.$ext;
            $file->move(public_path('upload/homework/'),$filename);
            $homework->document_file = $filename;
        }
        $homework->save();

        return redirect('/admin/homework/homework')->with('success','Homework Saved Successfully.');

    }

    public function EditHomework($id)
    {
        $getRecord = HomeworkModel::getSingle($id);
        $data['getRecord'] = $getRecord;
        $getSubject =  ClassSubjectModel::mySubject($getRecord->class_id);
        $data['getSubject'] = $getSubject;
        $data['getClass'] = ClassModel::getClass();
        $data['header_title'] = 'Edit Homework';
        return view('backend.admin.Homework.edit',$data);
    }
    public function UpdateHomework(Request $request,$id)
    {
        $homework = HomeworkModel::getSingle($id);
        $homework->class_id = trim($request->class_id);
        $homework->subject_id = trim($request->subject_id);
        $homework->homework_date = trim($request->homework_date);
        $homework->submission_date = trim($request->submission_date);
        $homework->description = trim($request->description);
        $homework->created_by = Auth::user()->id;
        if (!empty($request->file('document_file'))) {
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            @unlink(public_path('upload/homework/'.$homework->document_file));
            $random = date('mdYHs').uniqid();
            $filename =$random.'.'.$ext;
            $file->move(public_path('upload/homework/'),$filename);
            $homework->document_file = $filename;
        }
        $homework->save();

        return redirect('/admin/homework/homework')->with('success','Homework Updated Successfully.');
    }
    public function DeleteHomework($id)
    {
        $homework = HomeworkModel::getSingle($id);
        $homework->is_delete = 1;
        $homework->save();


        return redirect()->back()->with('success','Homework Deleted Successfully.');

    }
    public function SubmittedHomework($homework_id)
    {
        $homework = HomeworkModel::getSingle($homework_id);
        if (!empty($homework)) {
            $data['homework_id'] = $homework_id;
            $data['getRecord'] = HomeworkSubmitModel::getRecord($homework_id);
            $data['header_title'] = 'Submitted Homework';
            return view('backend.admin.Homework.submitted_homework',$data); 
        }
        else
        {
            abort(404);
        }
    }



//teacher side 

    public function HomeworkTeacher()
    {
        $class_ids = array();
        $getClass = AssignClassTeacherModel::MySubjectClassGroup(Auth::user()->id);
        foreach ($getClass as $value) {
            $class_ids[] = $value->class_id;
        }
        $data['getRecord'] = HomeworkModel::getRecordTeacher($class_ids);
        $data['header_title'] = 'Homework';
        return view('backend.teacher.Homework.list',$data);
    }
    public function HomeworkAddTeacher()
    {
        $data['getClass'] = AssignClassTeacherModel::MySubjectClassGroup(Auth::user()->id);
        $data['header_title'] = 'Add New Homework';
        return view('backend.teacher.Homework.add',$data);
    }
    
    public function InsertHomeworkTeacher(Request $request)
        {
            $homework = new HomeworkModel();
            $homework->class_id = trim($request->class_id);
            $homework->subject_id = trim($request->subject_id);
            $homework->homework_date = trim($request->homework_date);
            $homework->submission_date = trim($request->submission_date);
            $homework->description = trim($request->description);
            $homework->created_by = Auth::user()->id;
            if (!empty($request->file('document_file'))) {
                $ext = $request->file('document_file')->getClientOriginalExtension();
                $file = $request->file('document_file');
                $random = date('mdYHs').uniqid();
                $filename =$random.'.'.$ext;
                $file->move(public_path('upload/homework/'),$filename);
                $homework->document_file = $filename;
            }
            $homework->save();

            return redirect('/teacher/homework/homework')->with('success','Homework Saved Successfully.');

        }

        public function EditHomeworkTeacher($id)
        {
            $getRecord = HomeworkModel::getSingle($id);
            $data['getRecord'] = $getRecord;
            $getSubject =  ClassSubjectModel::mySubject($getRecord->class_id);
            $data['getSubject'] = $getSubject;
                    $data['getClass'] = AssignClassTeacherModel::MySubjectClassGroup(Auth::user()->id);
            $data['header_title'] = 'Edit Homework';
            return view('backend.teacher.Homework.edit',$data);
        }
        public function UpdateHomeworkTeacher(Request $request,$id)
        {
            $homework = HomeworkModel::getSingle($id);
            $homework->class_id = trim($request->class_id);
            $homework->subject_id = trim($request->subject_id);
            $homework->homework_date = trim($request->homework_date);
            $homework->submission_date = trim($request->submission_date);
            $homework->description = trim($request->description);
            $homework->created_by = Auth::user()->id;
            if (!empty($request->file('document_file'))) {
                $ext = $request->file('document_file')->getClientOriginalExtension();
                $file = $request->file('document_file');
                @unlink(public_path('upload/homework/'.$homework->document_file));
                $random = date('mdYHs').uniqid();
                $filename =$random.'.'.$ext;
                $file->move(public_path('upload/homework/'),$filename);
                $homework->document_file = $filename;
            }
            $homework->save();

            return redirect('/teacher/homework/homework')->with('success','Homework Updated Successfully.');

        }
        public function DeleteHomeworkTeacher($id)
        {
            $homework = HomeworkModel::getSingle($id);
            $homework->is_delete = 1;
            $homework->save();


            return redirect()->back()->with('success','Homework Deleted Successfully.');
        }

        public function SubmittedHomeworkTeacher($homework_id)
        {
            $homework = HomeworkModel::getSingle($homework_id);
            if (!empty($homework)) {
                $data['homework_id'] = $homework_id;
                $data['getRecord'] = HomeworkSubmitModel::getRecord($homework_id);
                $data['header_title'] = 'Submitted Homework';
                return view('backend.teacher.Homework.submitted_homework',$data); 
            }
            else
            {
                abort(404);
            }
        }



//student side homework
        public function HomeworkStudent()
        {
            $data['getRecord'] = HomeworkModel::getRecordStudent(Auth::user()->class_id,Auth::user()->id);
            $data['header_title'] = 'My Homework';
            return view('backend.student.my_homework.my_homework',$data); 
        }

        public function MyHomeworkSubmit($homework_id)
        {
            $data['getRecord'] = HomeworkModel::getSingle($homework_id);
            $data['header_title'] = 'Submit My Homework';
            return view('backend.student.my_homework.my_homework_submit',$data);
        }

        public function MyHomeworkSubmitInsert($homework_id,Request $request)
        {
            $homework  = new HomeworkSubmitModel();
            $homework->homework_id = $homework_id;
            $homework->student_id = Auth::user()->id;
            $homework->description = $request->description;
            if (!empty($request->file('document_file'))) {
                $ext = $request->file('document_file')->getClientOriginalExtension();
                $file = $request->file('document_file');
                $random = date('mdYHs').uniqid();
                $filename =$random.'.'.$ext;
                $file->move(public_path('upload/homework/'),$filename);
                $homework->document_file = $filename;
            }
            $homework->save();

            return redirect('/student/my_homework')->with('success','Homework Submitted Successfully.');


        }

        public function HomeworkSubmittedStudent()
        {
            $data['getRecord'] = HomeworkSubmitModel::getSubmittedStudentHomework(Auth::user()->id);
            $data['header_title'] = 'My Submitted Homework';
            return view('backend.student.my_homework.my_submitted_homework_list',$data); 
        }
        
//parent side
        public function MychildHomework($student_id)
        {

            $getChild = User::getSingle($student_id);
            $data['getChild'] = $getChild;
            $data['getRecord'] = HomeworkModel::getRecordStudent($getChild->class_id,$getChild->id);
            $data['header_title'] = 'My Child Homework';
            return view('backend.parent.Homework.my_child_homework',$data); 
        }
        public function MychildSubmittedHomework($student_id)
        {
            $data['student_id'] = $student_id;
            $data['getRecord'] = HomeworkSubmitModel::getSubmittedStudentHomework($student_id);
            $data['header_title'] = 'My Child Submitted Homework';
            return view('backend.parent.Homework.my_child_submitted_homework',$data); 
        }
        

}
