<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\ChatModel;


class ChatController extends Controller
{
    public function Chat(Request $request)
    {
        $sender_id = Auth::user()->id;

        $data['header_title'] = 'My Chat';
        if (!empty($request->receiver_id)) {
            $receiver_id = base64_decode($request->receiver_id);
            if ($receiver_id==$sender_id) {
                return redirect()->back()->with('error','Due to Some error Please try again.');
                exit();
            }
            ChatModel::updateCount($sender_id,$receiver_id);
        $data['receiver_id'] = $receiver_id;
        $data['getReceiver'] = User::getSingle($receiver_id);
        $data['getChat'] = ChatModel::getChat($receiver_id,$sender_id);
        }else{
            $data['receiver_id'] = '';

        }

        $data['getChatUser'] = ChatModel::getChatUser($sender_id);

        return view('backend.chat.chat',$data);
    }


    public function SubmitMessage(Request $request)
    {
        $chat = new ChatModel();
        $chat->sender_id = Auth::user()->id;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;
        if (!empty($request->file('file_name'))) {
            $ext = $request->file('file_name')->getClientOriginalExtension();
            $file = $request->file('file_name');
            $random = date('mdYHas').uniqid();
            $filename =$random.'.'.$ext;
            $file->move(public_path('upload/chat_pics/'),$filename);
            $chat->file_name = $filename;
        }
        $chat->created_date = time();
        $chat->save();

        $getChat = ChatModel::where('id','=',$chat->id)->get();

        return response()->json([
            "status" => true,
            "success" =>view('backend.chat._single',[
                "getChat" =>$getChat
            ])->render(),
        ],200);
    }

    public function GetChatWindows(Request $request)
    {
        $receiver_id = $request->receiver_id;
        $sender_id = Auth::user()->id;

        ChatModel::updateCount($sender_id,$receiver_id);

        $getReceiver = User::getSingle($receiver_id);
        $getChat = ChatModel::getChat($receiver_id,$sender_id);

        return response()->json([
            "status" => true,
            "receiver_id" => base64_encode($receiver_id),
            "success" =>view('backend.chat._message',[
                "getReceiver" =>$getReceiver,
                "getChat" =>$getChat,
            ])->render(),
        ],200);
    }

    public function get_chat_search_user(Request $request)
    {
      $receiver_id = $request->receiver_id;
      $sender_id = Auth::user()->id;
      $getChatUser = ChatModel::getChatUser($sender_id); 

      return response()->json([
            "status" => true,
            "success" =>view('backend.chat._user',[
                "getChatUser" =>$getChatUser,
                "receiver_id" =>$receiver_id,
            ])->render(),
        ],200);
    }
}
