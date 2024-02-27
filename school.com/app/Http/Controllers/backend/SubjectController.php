<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\SubjectModel;
use App\Models\User;
use App\Models\ClassSubjectModel;

class SubjectController extends Controller
{
    public function list()
    {
        $data['getRecord']= SubjectModel::getRecord();
        $data['header_title'] = 'Subject List';
        return view('backend.admin.subject.list',$data);
    }

    public function add()
    {
        $data['header_title'] = 'Add New Subject';
        return view('backend.admin.subject.add',$data);
    }
    public function store(Request $request)
    {
        $subject_name = new SubjectModel();
        $subject_name->name = trim($request->name);
        $subject_name->type = trim($request->type);
        $subject_name->status = trim($request->status);
        $subject_name->created_by = Auth::user()->id;
        $subject_name->save();

        return redirect()->route('admin.subject.list')->with('success','Subject successfully created');
    }

    public function edit($id)
    {
        $data['getRecord'] = SubjectModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Subject';
            return view('backend.admin.subject.edit',$data);
        }
        else
        {
            abort(404);
        }
    }

    public function update($id,Request $request)
    {
        $subject_name = SubjectModel::getSingle($id);
        $subject_name->name = trim($request->name);
        $subject_name->type = trim($request->type);
        $subject_name->status = trim($request->status);
        $subject_name->save();
        return redirect()->route('admin.subject.list')->with('success','Subject successfully Updated');
    }
    public function delete($id)
    {
        $subject_name = SubjectModel::getSingle($id);
        $subject_name->is_delete = 1;
        $subject_name->save();
        return redirect()->back()->with('success','Subject successfully deleted');
    }
//student side
    public function MySubject()
    {
        $class_id = Auth::User()->class_id;
        $data['getRecord']= ClassSubjectModel::mySubject($class_id);
        $data['header_title'] = 'Subject List';
        return view('backend.student.student_list',$data);
    }
//parent side 
    public function myChildrenSubject($student_id)
    {
        $user = User::getSingle($student_id);
        $data['user'] = $user;
        $data['getRecord']= ClassSubjectModel::mySubject($user->class_id);
        $data['header_title'] = 'My Child Subject List';
        return view('backend.parent.my_children_subject_list',$data);

    }

}
