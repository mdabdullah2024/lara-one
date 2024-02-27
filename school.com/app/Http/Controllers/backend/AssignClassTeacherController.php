<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassSubjectModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\User;
use App\Models\AssignClassTeacherModel;
use Auth;
use Hash;
class AssignClassTeacherController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Assign Class Teacher';
        $data['getRecord'] = AssignClassTeacherModel::getRecord();
        
        return view('backend.admin.assign_class_teacher.list',$data);
    }


    public function add()
    {
        $data['header_title'] = 'Add Assign Class Teacher';
        $data['getClasses'] = ClassModel::getClass();
        $data['getTeacher'] = User::getTeacherClass();

        return view('backend.admin.assign_class_teacher.add',$data);
    }

    public function store(Request $request)
    {
        
        if (!empty($request->teacher_id)) {
            foreach($request->teacher_id as $teacher_id)
            {
                $getAlreadyfirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id,$teacher_id);
                if (!empty($getAlreadyfirst)) {
                    $getAlreadyfirst->status = $request->status;
                    $getAlreadyfirst->save();
                }else{
                    $save = new  AssignClassTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
                

            }
            return redirect()->route('admin.assign_class_teacher.list')->with('success','Assign Class Teacher successfully created .');

        }else{
            return redirect()->back()->with('error','Something went wrong try again.');
        }
    }


    public function edit($id)
    {
        $getRecord  = AssignClassTeacherModel::getSingle($id);
        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['header_title'] = 'Edit Assign Class Teacher';
            $data['getAssignClassTeacherID'] = AssignClassTeacherModel::getAssignClassTeacherID($getRecord->class_id);
            $data['getClasses'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();

            return view('backend.admin.assign_class_teacher.edit',$data);
        }else{
            abort(404);
        }
    }

    public function update($id,Request $request)
    {
          AssignClassTeacherModel::deleteTeacher($request->class_id);

        if (!empty($request->teacher_id)) {
            foreach($request->teacher_id as $teacher_id)
            {
                $getAlreadyfirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id,$teacher_id);
                if (!empty($getAlreadyfirst)) {
                    $getAlreadyfirst->status = $request->status;
                    $getAlreadyfirst->save();
                }else{
                    $save = new  AssignClassTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
                

            }
            return redirect()->route('admin.assign_class_teacher.list')->with('success','Assign Class Teacher successfully Updated.');

        }else{
            return redirect()->back()->with('error','Something went wrong try again.');
        }
    }

    

    public function editSingle($id)
    {
        $getRecord  = AssignClassTeacherModel::getSingle($id);
        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['header_title'] = 'Edit Single Assign Class Teacher';
            $data['getClasses'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();

            return view('backend.admin.assign_class_teacher.edit_single',$data);
        }else{
            abort(404);
        }
    }

    public function updateSingle($id,Request $request)
    {
        $getAlreadyFirst =  AssignClassTeacherModel::getAlreadyFirst($request->class_id,$request->teacher_id);

        if (!empty($getAlreadyFirst)) {
            $getAlreadyFirst->status = $request->status;
            $getAlreadyFirst->save();

            return redirect()->route('admin.assign_class_teacher.list')->with('success','status successfully Updated.');
        }else{
            $save = AssignClassTeacherModel::getSingle($id);
            $save->class_id = $request->class_id;
            $save->teacher_id = $request->teacher_id;
            $save->status = $request->status;
            $save->save();
            return redirect()->route('admin.assign_class_teacher.list')->with('success','Assign Class Teacher successfully Updated.');
        }

    }
    public function delete($id)
    {
        $getRecord = AssignClassTeacherModel::getSingle($id);
        $getRecord->delete();

        return redirect()->back()->with('success','Assign Class Teacher successfully Deleted.');
    }

    public function MyClassSubject()
    {
        $data['header_title'] = 'My Class & Subject';
        $data['getRecord'] = AssignClassTeacherModel::MySubjectClass(Auth::user()->id);
        
        return view('backend.teacher.my_class_subject',$data);
    }
}
