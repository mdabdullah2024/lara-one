<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
class AdminController extends Controller
{
    public function list()
    {
        $data['getRecord'] = User::getAdmin();
        $data['header_title'] = 'Admin list';
        return view('backend.admin.admin.list',$data);
    }

    public function add()
    {

        $data['header_title'] = 'Add New Admin';
        return view('backend.admin.admin.add',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' =>'required|email|unique:users,email',
            'name' =>'required',
            'profile_pic' =>'sometimes|mimes:jpeg,jpg,png,jif,bmp',
        ]);
        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $random = date('mdYHas').uniqid();
            $filename =$random.'.'.$ext;
            $file->move(public_path('upload/profile_images/'),$filename);
            $user->profile_pic = $filename;
        }
        $user->password = Hash::make($request->password);
        $user->user_type = 1;
        $user->save();
        return redirect()->route('admin.admin.list')->with('success','Admin successfully created.');
    }

    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
           $data['header_title'] = 'Admin Edit';
            return view('backend.admin.admin.edit',$data);
        }else{
            abort(404);
        }
        
    }

    public function update($id,Request $request)
    {
        $request->validate([
            'email' =>'required|email|unique:users,email,'.$id ,
            'profile_pic' =>'sometimes|mimes:jpeg,jpg,png,jif,bmp',

        ]);
        $user =  User::getSingle($id);
        $user->name = trim($request->name);
        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            @unlink(public_path('upload/profile_images/'.$user->profile_pic));
            $random = date('mdYHas').uniqid();
            $filename =$random.'.'.$ext;
            $file->move(public_path('upload/profile_images/'),$filename);
            $user->profile_pic = $filename;
        }
        $user->email = trim($request->email);

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('admin.admin.list')->with('success','Admin successfully Updated.');
    }

    public function delete($id)
    {
        $user =  User::getSingle($id);
        $user->is_delete = 1;
        $user->save();
        return redirect()->route('admin.admin.list')->with('success','Admin successfully deleted.');
    }

    
}
