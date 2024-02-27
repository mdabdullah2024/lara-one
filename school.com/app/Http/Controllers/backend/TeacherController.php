<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel;
use Auth;
use Hash;

class TeacherController extends Controller
{
     public function list()
    {
        $data['classes']= ClassModel::getClass();
        $data['getRecord'] = User::getTeacher();
        $data['header_title']='Teacher list';
        return view('backend.admin.teacher.list',$data);
    }

    public function add()
    {

        $data['header_title']='Add New Teacher';
        $data['classes']= ClassModel::getClass();
        return view('backend.admin.teacher.add',$data);
    }

    public function store(Request $request)
    {
        request()->validate([
            'email'=>'required | email | unique:users,email',
            'password'=>'min:3',
            'name'=>'required',
            'last_name'=>'required',
            'last_name'=>'required',
            'gender'=>'required',
            'address'=>'max:255',
            'permanet_address'=>'max:255',
            'qualification'=>'max:255',
            'work_experience'=>'max:255',
            'note'=>'max:255',
            'admission_date'=>'required',
            'mobile_number'=>'required|max:12',
            'status'=>'required',
            'profile_pic'=>'sometimes | mimes:jpeg,jpg,png,jif,bmp',

        ]);
        $teacher = new User();
        $teacher->name = trim($request->name);
        $teacher->last_name = trim($request->last_name);
        $teacher->gender = trim($request->gender);
        $teacher->address = trim($request->address);
        $teacher->permanent_address = trim($request->permanent_address);
        $teacher->qualification = trim($request->qualification);
        $teacher->work_experience = trim($request->work_experience);
        $teacher->note = trim($request->note);
        if (!empty($request->date_of_birth)) {
           $teacher->date_of_birth = $request->date_of_birth;
        }

        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $random = date('mdYHas').uniqid();
            $filename =$random.'.'.$ext;
            $file->move(public_path('upload/profile_images/'),$filename);
            $teacher->profile_pic = $filename;
        }

        $teacher->admission_date = trim($request->admission_date);
        $teacher->mobile_number = trim($request->mobile_number);
        $teacher->status = trim($request->status);
        $teacher->marital_status = trim($request->marital_status);
        $teacher->user_type = 2;
        $teacher->email = trim($request->email);
        $teacher->password = Hash::make($request->password);
        $teacher->save();

        return redirect()->route('admin.teacher.list')->with('success','teacher successfully created.');
    }

    public function edit($id)
    {
        $data['getRecord']=  User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title']='Edit teacher';
            $data['classes']= ClassModel::getClass();
            return view('backend.admin.teacher.edit',$data);
        }else{
            abort(404);
        }
    }

    public function update($id,Request $request)
    {
        request()->validate([
            'email'=>'required | email | unique:users,email,'.$id,
            'name'=>'required',
            'last_name'=>'required',
            'last_name'=>'required',
            'gender'=>'required',
            'address'=>'max:255',
            'permanet_address'=>'max:255',
            'qualification'=>'max:255',
            'work_experience'=>'max:255',
            'note'=>'max:255',
            'admission_date'=>'required',
            'mobile_number'=>'required|max:12',
            'status'=>'required',
            'profile_pic'=>'sometimes | mimes:jpeg,jpg,png,jif,bmp',

        ]);
        $teacher = User::getSingle($id);
        $teacher->name = trim($request->name);
        $teacher->last_name = trim($request->last_name);
        $teacher->gender = trim($request->gender);
        $teacher->address = trim($request->address);
        $teacher->permanent_address = trim($request->permanent_address);
        $teacher->qualification = trim($request->qualification);
        $teacher->work_experience = trim($request->work_experience);
        $teacher->note = trim($request->note);
        if (!empty($request->date_of_birth)) {
           $teacher->date_of_birth = $request->date_of_birth;
        }

        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            @unlink(public_path('upload/profile_images/'.$teacher->profile_pic));
            $random = date('mdYHas').uniqid();
            $filename =$random.'.'.$ext;
            $file->move(public_path('upload/profile_images/'),$filename);
            $teacher->profile_pic = $filename;
        }

        
        $teacher->admission_date = trim($request->admission_date);
        $teacher->mobile_number = trim($request->mobile_number);
        $teacher->status = trim($request->status);
        $teacher->marital_status = trim($request->marital_status);
        $teacher->user_type = 2;
        $teacher->email = trim($request->email);
        if (!empty($request->password)) {
            $teacher->password = Hash::make($request->password);
        }
        $teacher->save();

        return redirect()->route('admin.teacher.list')->with('success','teacher successfully Updated.');
    }


    public function delete($id)
    {
        $getRecord = User::getSingle($id);
        if (!empty($getRecord)) {
            $getRecord->is_delete = 1;
            $getRecord->save();
        return redirect()->route('admin.teacher.list')->with('success','teacher successfully deleted.');

        }else{
            abort(404);
        }
    }

}
