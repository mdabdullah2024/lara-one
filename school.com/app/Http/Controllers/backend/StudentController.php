<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel;
use Auth;
use Hash;
use Str;
class StudentController extends Controller
{
    public function list()
    {
        $data['classes']= ClassModel::getClass();
        $data['getRecord'] = User::getStudent();
        $data['header_title']='Student list';
        return view('backend.admin.student.list',$data);
    }

    public function add()
    {

        $data['header_title']='Add new Student';
        $data['classes']= ClassModel::getClass();
        return view('backend.admin.student.add',$data);
    }

    public function store(Request $request)
    {
        request()->validate([
            'email'=>'required | email | unique:users,email',
            'password'=>'min:6',
            'name'=>'required',
            'last_name'=>'required',
            'admission_number'=>'required',
            'gender'=>'required',
            'roll_number'=>'required',
            'class_id'=>'required',
            'profile_pic'=>'sometimes',
            'admission_date'=>'required',
            'caste'=>'max:10',
            'mobile_number'=>'required|max:12',
            'status'=>'required',
            'height'=>'max:10',
            'weight'=>'max:10',
            'blood_group'=>'max:10',
            'date_of_birth'=>'required',
            'profile_pic'=>'sometimes',

        ]);
        $student = new User();
        $student->name = trim($request->name);
        $student->last_name = trim($request->last_name);
        $student->admission_number = trim($request->admission_number);
        $student->roll_number = trim($request->roll_number);
        $student->class_id = trim($request->class_id);
        $student->gender = trim($request->gender);
        if (!empty($request->date_of_birth)) {
           $student->date_of_birth = $request->date_of_birth;
        }

        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $random = date('mdYHas').uniqid();
            $filename =$random.'.'.$ext;
            $file->move(public_path('upload/profile_images/'),$filename);
            $student->profile_pic = $filename;
        }

        $student->admission_date = trim($request->admission_date);
        $student->caste = trim($request->caste);
        $student->religion = trim($request->religion);
        $student->mobile_number = trim($request->mobile_number);
        $student->blood_group = trim($request->blood_group);
        $student->status = trim($request->status);
        $student->height = trim($request->height);
        $student->user_type = 3;
        $student->weight = trim($request->weight);
        $student->email = trim($request->email);
        $student->password = Hash::make($request->password);
        $student->save();

        return redirect()->route('admin.student.list')->with('success','Student successfully created.');
    }

    public function edit($id)
    {
        $data['getRecord']=  User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title']='Edit Student';
            $data['classes']= ClassModel::getClass();
            return view('backend.admin.student.edit',$data);
        }else{
            abort(404);
        }
    }

    public function update($id,Request $request)
    {
        request()->validate([
            'email'=>'required | email | unique:users,email,'.$id,
            'profile_pic'=>'sometimes | mimes:jpeg,png,jpg,bmp,jif',
            'admission_date'=>'required',
            'caste'=>'max:10',
            'mobile_number'=>'required|max:16',
            'status'=>'required',
            'height'=>'max:10',
            'weight'=>'max:10',
            'blood_group'=>'max:10',
            'date_of_birth'=>'required',

        ]);
        $student = User::getSingle($id);
        $student->name = trim($request->name);
        $student->last_name = trim($request->last_name);
        $student->admission_number = trim($request->admission_number);
        $student->roll_number = trim($request->roll_number);
        $student->class_id = trim($request->class_id);
        $student->gender = trim($request->gender);
        if (!empty($request->date_of_birth)) {
           $student->date_of_birth = $request->date_of_birth;
        }

        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            @unlink(public_path('upload/profile_images/'.$student->profile_pic));
            $random = date('mdYHas').uniqid();
            $filename =$random.'.'.$ext;
            $file->move(public_path('upload/profile_images/'),$filename);
            $student->profile_pic = $filename;
        }

        $student->admission_date = trim($request->admission_date);
        $student->caste = trim($request->caste);
        $student->religion = trim($request->religion);
        $student->mobile_number = trim($request->mobile_number);
        $student->blood_group = trim($request->blood_group);
        $student->status = trim($request->status);
        $student->height = trim($request->height);
        $student->user_type = 3;
        $student->weight = trim($request->weight);
        $student->email = trim($request->email);
        if (!empty($request->password)) {
            $student->password = Hash::make($request->password);
        }
        $student->save();

        return redirect()->route('admin.student.list')->with('success','Student successfully Updated.');
    }


    public function delete($id)
    {
        $getRecord = User::getSingle($id);
        if (!empty($getRecord)) {
            $getRecord->is_delete = 1;
            $getRecord->save();
        return redirect()->route('admin.student.list')->with('success','Student successfully deleted.');

        }else{
            abort(404);
        }
    }

//teacher side 
public function MyStudentTeacher()
    {
        $data['classes']= ClassModel::getClass();
        $data['getRecord'] = User::getStudentoOfTeacher(Auth::user()->id);
        $data['header_title']='Student list';
        return view('backend.teacher.my_student',$data);
    }

}
