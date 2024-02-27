<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\NoticeBoardModel;
use App\Models\NoticeBoardMessageModel;
use App\Mail\SendEmailUserMail;
use Mail;


class CommunicateController extends Controller
{
    public function SendEmail()
    {
        $data['header_title'] = 'Send Email';
        return view('backend.admin.communicate.send_email.send_email',$data);
    }

    public function SearchUser(Request $request)
    {
        $json = array();
        if (!empty($request->search)) {
            $getUser = User::SearchUser($request->search);
            foreach($getUser as $value)
            {
                $type = '';
                if ($value->user_type==1) {
                    $type = 'Admin';
                }
                else if ($value->user_type==2) {
                    $type = 'Teacher';
                }
                else if ($value->user_type==3) {
                    $type = 'Student';
                }
                else if ($value->user_type==4) {
                    $type = 'Parent';
                }
                $name = $value->name.' '.$value->last_name.' ('.$type.')';
                $json[] = ['id'=>$value->id,'text' =>$name];
            }
        }
        echo json_encode($json);
    }

    public function SendEmailUser(Request $request)
    {
        if (!empty($request->user_id)) {
            $user = User::getSingle($request->user_id);
            $user->send_message = $request->message;
            $user->send_subject = $request->subject;
            Mail::to($user->email)->send(new SendEmailUserMail($user));
        }
        if (!empty($request->message_to)) {
            foreach($request->message_to as $user_type){
                $allUser = User::AllUser($user_type);

                foreach($allUser as $user )
                {
                    $user->send_message = $request->message;
                    $user->send_subject = $request->subject;
                    Mail::to($user->email)->send(new SendEmailUserMail($user)); 
                }
            }
        }
        return redirect()->back()->with('success','Mail Successfully sent');   
    }
    

    public function NoticeBoard()
    {
        $data['getRecord'] = NoticeBoardModel::getRecord();
        $data['header_title'] = 'Notice Board';
        return view('backend.admin.communicate.notice_board.list',$data);
    }

    public function AddNoticeBoard()
    {
        //$data['getRecord'] = User::getAdmin();
        $data['header_title'] = 'Add New Notice Board';
        return view('backend.admin.communicate.notice_board.add',$data);
    }

    public function InsertNoticeBoard(Request $request)
    {
        $save = new NoticeBoardModel();
        $save->title = $request->title;
        $save->notice_date = $request->notice_date;
        $save->publish_date = $request->publish_date;
        $save->message = $request->message;
        $save->created_by = Auth::user()->id;
        $save->save();

        if (!empty($request->message_to)) {
            foreach($request->message_to as $message_to)
            {
                $message = new NoticeBoardMessageModel();
                $message->notice_board_id = $save->id;
                $message->message_to = $message_to;
                $message->save();
            }
        }
        

        return redirect('/admin/communicate/notice_board')->with('success','Notice Added Successfully.');
    }

    public function EditNoticeBoard($id)
    {
        $data['getRecord'] = NoticeBoardModel::getSingle($id);
        $data['header_title'] = 'Edit Notice Board';
        return view('backend.admin.communicate.notice_board.edit',$data);
    }

    public function UpdateNoticeBoard($id,Request $request)
    {
        $save =  NoticeBoardModel::getSingle($id);
        $save->title = $request->title;
        $save->notice_date = $request->notice_date;
        $save->publish_date = $request->publish_date;
        $save->message = $request->message;
        $save->created_by = Auth::user()->id;
        $save->save();


        NoticeBoardMessageModel::DeleteRecord($id);

        if (!empty($request->message_to)) {
            foreach($request->message_to as $message_to)
            {
                $message = new NoticeBoardMessageModel();
                $message->notice_board_id = $save->id;
                $message->message_to = $message_to;
                $message->save();
            }
        }


        
        return redirect('/admin/communicate/notice_board')->with('success','Notice Updated Successfully.');
    }

    public function DeleteNoticeBoard($id)
    {
        $delete = NoticeBoardModel::getSingle($id);
        $delete->delete();
        NoticeBoardMessageModel::DeleteRecord($id);
        return redirect()->back()->with('success','Notice Deleted Successfully.');
    }

//student side notice board
    public function MyNoticeBoardStudent()
    {
        $data['getRecord'] = NoticeBoardModel::getRecordUser(Auth::user()->user_type);
        $data['header_title'] = 'My Notice Board';
        return view('backend.student.communicate.my_notice_board',$data);
    }

//Teacher side notice board
    public function MyNoticeBoardTeacher()
    {
        $data['getRecord'] = NoticeBoardModel::getRecordUser(Auth::user()->user_type);
        $data['header_title'] = 'My Notice Board';
        return view('backend.teacher.communicate.my_notice_board',$data);
    }

//Teacher side notice board
    public function MyNoticeBoardParent()
    {
        $data['getRecord'] = NoticeBoardModel::getRecordUser(Auth::user()->user_type);
        $data['header_title'] = 'My Child Notice Board';
        return view('backend.parent.communicate.my_notice_board',$data);
    }


    
}
