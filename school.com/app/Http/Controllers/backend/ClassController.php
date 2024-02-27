<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\ClassModel;
class ClassController extends Controller
{
    public function list()
    {
        $data['getRecord']= ClassModel::getRecord();
        $data['header_title'] = 'Class List';
        return view('backend.admin.class.list',$data);
    }
    public function add()
    {
        $data['header_title'] = 'Add New Class';
        return view('backend.admin.class.add',$data);
    }
    public function store(Request $request)
    {
        $classname = new ClassModel();
        $classname->name = $request->name;
        $classname->amounts = $request->amounts;
        $classname->status = $request->status;
        $classname->created_by = Auth::user()->id;
        $classname->save();

        return redirect()->route('admin.class.list')->with('success','Class successfully created');
    }

    public function edit($id)
    {
        $data['getRecord'] = ClassModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Class';
            return view('backend.admin.class.edit',$data);
        }
        else
        {
            abort(404);
        }
    }

    public function update($id,Request $request)
    {
        $save= ClassModel::getSingle($id);
        $save->name = $request->name;
        $save->amounts = $request->amounts;
        $save->status = $request->status;
        $save->save();
        return redirect()->route('admin.class.list')->with('success','Class successfully Updated');
    }
    public function delete($id)
    {
        $save= ClassModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();
        return redirect()->back()->with('success','Class successfully deleted');
    }
}
