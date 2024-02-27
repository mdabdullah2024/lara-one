<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassSubjectModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use Auth;

class ClassSubjectController extends Controller
{
    public function list(Request $request)
    {
        $data['header_title'] = 'Assign Subject class';
        $data['getRecord'] = ClassSubjectModel::getRecord();

        return view('backend.admin.assign_subject.list',$data);
    }

    public function add()
    {
        $data['header_title'] = 'Assign Subject class';
        $data['getClass'] = ClassModel::getClass();
        $data['getSubject'] = SubjectModel::getSubject();
        return view('backend.admin.assign_subject.add',$data);
    }

    public function store(Request $request)
    {
        if (!empty($request->subject_id)) {
            foreach($request->subject_id as $subject_id)
            {
                $getAlreadyfirst = ClassSubjectModel::getAlreadyFirst($request->class_id,$subject_id);
                if (!empty($getAlreadyfirst)) {
                    $getAlreadyfirst->status = $request->status;
                    $getAlreadyfirst->save();
                }else{
                    $save = new  ClassSubjectModel;
                    $save->class_id = $request->class_id;
                    $save->subject_id = $subject_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
                

            }
            return redirect()->route('admin.class_subject.list')->with('success','Assign Subject successfully created to the class.');

        }else{
            return redirect()->back()->with('error','Something went wrong try again.');
        }
    }

    public function edit($id)
    {
        $getRecord = ClassSubjectModel::getSingle($id);
        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['getAssignSubjectID'] = ClassSubjectModel::getAssignSubjectID($getRecord->class_id);
            $data['header_title'] = 'Edit Class Assign Subject ';
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            return view('backend.admin.assign_subject.edit',$data);
        }
        else
        {
            abort(404);
        }
    }

    public function update(Request $request)
    {
        ClassSubjectModel::Deletesubject($request->class_id);

        if (!empty($request->subject_id)) {
            foreach($request->subject_id as $subject_id)
            {
                $getAlreadyfirst = ClassSubjectModel::getAlreadyFirst($request->class_id,$subject_id);
                if (!empty($getAlreadyfirst)) {
                    $getAlreadyfirst->status = $request->status;
                    $getAlreadyfirst->save();
                }else{
                    $save = new  ClassSubjectModel;
                    $save->class_id = $request->class_id;
                    $save->subject_id = $subject_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
                

            }
            return redirect()->route('admin.class_subject.list')->with('success','Assign Subject successfully updated.');
        }
        
    }
    public function delete($id)
    {
        $save= ClassSubjectModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();
        return redirect()->back()->with('success','Record successfully deleted');
    }

    public function editSingle($id)
    {
         $getRecord = ClassSubjectModel::getSingle($id);
        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['header_title'] = 'Edit Class Assign Subject ';
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            return view('backend.admin.assign_subject.editSingle',$data);
        }
        else
        {
            abort(404);
        }
    }

    public function updateSingle($id,Request $request)
    {
                $getAlreadyfirst = ClassSubjectModel::getAlreadyFirst($request->class_id,$request->subject_id);
                if (!empty($getAlreadyfirst)) {
                    $getAlreadyfirst->status = $request->status;
                    $getAlreadyfirst->save();
                    return redirect()->route('admin.class_subject.list')->with('success','Status successfully updated.');

                }else{
                    $save = ClassSubjectModel::getSingle($id);
                    $save->class_id = $request->class_id;
                    $save->subject_id = $request->subject_id;
                    $save->status = $request->status;
                    $save->save();

                    return redirect()->route('admin.class_subject.list')->with('success','Assign Subject successfully updated.');
                }
                

            
            
        
    }
}
