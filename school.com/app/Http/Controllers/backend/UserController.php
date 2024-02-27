<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\SettingsModel;
use Auth;
use Hash;

class UserController extends Controller
{
    public function Settings()
    {
        $data['getRecord'] =  SettingsModel::getSingle();
        $data['header_title'] = 'Settings';
        return view('backend.admin.Settings.settings',$data);
    }
    public function SettingsUpdate(Request $request)
    {
        $request->validate([
            

        ]);
        $setting =  SettingsModel::getSingle();
        $setting->paypal_email = trim($request->paypal_email);

        if (!empty($request->file('fevicon_file'))) {
            $ext = $request->file('fevicon_file')->getClientOriginalExtension();
            $file = $request->file('fevicon_file');
            @unlink(public_path('upload/setting/'.$setting->fevicon_file));
            $random = date('mdYHas').uniqid();
            $filename =$random.'.'.$ext;
            $file->move(public_path('upload/setting/'),$filename);
            $setting->fevicon_file = $filename;
        }

        if (!empty($request->file('logo_file'))) {
            $ext = $request->file('logo_file')->getClientOriginalExtension();
            $file = $request->file('logo_file');
            @unlink(public_path('upload/setting/'.$setting->logo_file));
            $random = date('mdYHas').uniqid();
            $filename =$random.'.'.$ext;
            $file->move(public_path('upload/setting/'),$filename);
            $setting->logo_file = $filename;
        }

        $setting->save();
        return redirect()->back()->with('success','Record successfully Saved.');
    }
    public function change_password()
    {
        $data['header_title'] = 'Change Password';
        return view('backend.profile.change_password.change_password',$data);
    }
    public function change_passwordPost(Request $request)
    {
       $user = User::getSingle(Auth::user()->id);
       if (Hash::check($request->old_password,$user->password)) {
           $user->password = Hash::make($request->new_password);
           $user->save();
        return redirect()->back()->with('success','Your password successfully changed. ');
       }else{
        return redirect()->back()->with('error','Old Password does not match.');
       }
    }
public function myAccountAdmin()
    {
        $data['getRecord'] = User::getSingle(Auth::user()->id);
        $data['header_title'] = 'My Account';
        return view('backend.profile.my_account_admin.list',$data);
    }

    public function updateMyAccountAdmin(Request $request)
    {
        $id = Auth::User()->id;
         
        $request->validate([
            'email' =>'required|email|unique:users,email,'.$id ,

        ]);
        $user =  User::getSingle($id);
        $user->name = trim($request->name);
        if (!empty($request->last_name)) {
                    $user->last_name = trim($request->last_name);
        }
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
        $user->save();
        return redirect()->back()->with('success','Account successfully Updated.');
    }

    public function myAccount()
    {
        $data['getRecord'] = User::getSingle(Auth::user()->id);
        $data['header_title'] = 'My Account';
        return view('backend.profile.my_account_teacher.list',$data);
    }

    public function updateMyAccount(Request $request)
    {
        $id = Auth::user()->id;
         request()->validate([
            'email'=>'required | email | unique:users,email,'.$id,
            'mobile_number'=>'max:15|min:8',

        ]);
        $teacher = User::getSingle($id);
        $teacher->name = trim($request->name);
        $teacher->last_name = trim($request->last_name);
        $teacher->gender = trim($request->gender);
        $teacher->address = trim($request->address);
        $teacher->permanent_address = trim($request->permanent_address);
        $teacher->qualification = trim($request->qualification);
        $teacher->work_experience = trim($request->work_experience);
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
        $teacher->marital_status = trim($request->marital_status);
        $teacher->user_type = 2;
        $teacher->email = trim($request->email);
        $teacher->save();

        return redirect()->back()->with('success','Acount successfully Updated.');
    }

     public function myAccountStudent()
    {
        $data['classes']= ClassModel::getClass();
        $data['getRecord'] = User::getSingle(Auth::user()->id);
        $data['header_title'] = 'My Account';
        return view('backend.profile.my_account_student.list',$data);
    }

     public function updateMyAccountStudent(Request $request)
    {
        $id = Auth::User()->id;
         request()->validate([
            'email'=>'required | email | unique:users,email,'.$id,
            'address'=>'max:255',
            'parmanent_address'=>'max:255',

        ]);
        $student = User::getSingle($id);
        $student->name = trim($request->name);
        $student->last_name = trim($request->last_name);
        $student->gender = trim($request->gender);
        $student->address = trim($request->address);
        $student->permanent_address = trim($request->permanent_address);
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
        $student->caste = trim($request->caste);
        $student->religion = trim($request->religion);
        $student->mobile_number = trim($request->mobile_number);
        $student->blood_group = trim($request->blood_group);
        $student->height = trim($request->height);
        $student->user_type = 3;
        $student->weight = trim($request->weight);
        $student->email = trim($request->email);
        $student->save();

        return redirect()->back()->with('success','Account successfully Updated.');
    }

    public function myAccountParent()
    {
        $data['getRecord'] = User::getSingle(Auth::user()->id);
        $data['header_title'] = 'My Account';
        return view('backend.profile.my_account_parent.list',$data);
    }

    public function updateMyAccountParent(Request $request)
    {
        $id = Auth::User()->id;
          request()->validate([
            'email'=>'required | email | unique:users,email,'.$id,
            'address'=>'max:255',
            'permanent_address'=>'max:255',
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
        $parent->religion = trim($request->religion);
        $parent->caste = trim($request->caste);
        $parent->address = trim($request->address);
        $parent->permanent_address = trim($request->permanent_address);
        $parent->occupation = trim($request->occupation);
        $parent->user_type = 4;
        $parent->email = trim($request->email);
        $parent->save();

        return redirect()->back()->with('success','Account successfully Updated.');
    }
    
}
