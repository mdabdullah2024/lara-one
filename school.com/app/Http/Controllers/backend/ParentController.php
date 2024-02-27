<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;

class ParentController extends Controller
{
    public function list()
    {
        $data['getRecord'] = User::getParent();
        $data['header_title']='Parent list';
        return view('backend.admin.parent.list',$data);
    }

    public function add()
    {

        $data['header_title']='Add new Parent';
        return view('backend.admin.parent.add',$data);
    }

     public function store(Request $request)
    {
        request()->validate([
            'email'=>'required | email | unique:users,email',
            'password'=>'required | min:6',
            'name'=>'required',
            'profile_pic'=>'sometimes|mimes:jpeg,jpg,png,jif,bmp',
            'last_name'=>'required',

        ]);
        $parent = new User();
        $parent->name = trim($request->name);
        $parent->last_name = trim($request->last_name);
        $parent->gender = trim($request->gender);
        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $random = date('mdYHas').uniqid();
            $filename =$random.'.'.$ext;
            $file->move(public_path('upload/profile_images/'),$filename);
            $parent->profile_pic = $filename;
        }
        
        $parent->mobile_number = trim($request->mobile_number);
        $parent->address = trim($request->address);
        $parent->occupation = trim($request->occupation);
        $parent->status = trim($request->status);
        $parent->user_type = 4;
        $parent->email = trim($request->email);
        $parent->password = Hash::make($request->password);
        $parent->save();

        return redirect()->route('admin.parent.list')->with('success','Parent successfully created.');
    }
    public function edit($id)
    {
        $data['getRecord']=  User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title']='Edit Parent';
            return view('backend.admin.parent.edit',$data);
        }else{
            abort(404);
        }
    }

    public function update($id,Request $request)
    {
        request()->validate([
            'email'=>'required | email | unique:users,email,'.$id,
            'profile_pic'=>'sometimes|mimes:jpeg,jpg,png,jif,bmp',
            'name'=>'required',
            'last_name'=>'required',

        ]);
        $parent =  User::getSingle($id);
        $parent->name = trim($request->name);
        $parent->last_name = trim($request->last_name);
        $parent->gender = trim($request->gender);
        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            @unlink(public_path('upload/profile_images/'.$parent->profile_pic));
            $random = date('mdYHas').uniqid();
            $filename =$random.'.'.$ext;
            $file->move(public_path('upload/profile_images/'),$filename);
            $parent->profile_pic = $filename;
        }
        $parent->mobile_number = trim($request->mobile_number);
        $parent->address = trim($request->address);
        $parent->occupation = trim($request->occupation);
        $parent->status = trim($request->status);
        $parent->user_type = 4;
        $parent->email = trim($request->email);
        if (!empty($parent->password)) {
            $parent->password = Hash::make($request->password);
        }
        $parent->save();

        return redirect()->route('admin.parent.list')->with('success','Parent successfully Updated.');
    }

     public function delete($id)
    {
        $getRecord = User::getSingle($id);
        if (!empty($getRecord)) {
            $getRecord->is_delete = 1;
            $getRecord->save();
        return redirect()->route('admin.parent.list')->with('success','Parent successfully deleted.');

        }else{
            abort(404);
        }
    }

    public function myStudent($id)
    {
        $data['getParent']  = User::getSingle($id);
        $data['parent_id'] = $id;
        $data['getSearchStudent'] = User::getSearchStudent();
        $data['getRecord'] = User::getMyStudent($id);
        $data['header_title']='Parent Student list';
        return view('backend.admin.parent.student_list',$data);
    }

    public function AssignStudentParent($student_id,$parent_id)
    {
        $student=user::getSingle($student_id);
        $student->parent_id = $parent_id;
        $student->save();

        return redirect()->back()->with('success','Student successfully assigned to parent.');
    }

    public function AssignStudentParentDelete($student_id)
    {
        $student=user::getSingle($student_id);
        $student->parent_id = null;
        $student->save();
        
        return redirect()->back()->with('success','Parent successfully Deleted from student.');
    }

    public function myChildren()
    {
        $id = Auth::User()->id;
        $data['getRecord'] = User::getMyStudent($id);
        $data['header_title']='Parent Children list';
        return view('backend.parent.children_list',$data);
    }
    


}
