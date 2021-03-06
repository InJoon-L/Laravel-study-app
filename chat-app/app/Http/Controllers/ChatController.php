<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index() {
        return Inertia::render('Chat/container');
    }

    public function indexV2() {
        return Inertia::render('Chat/containerV2');
    }


    /*
        1. 채팅방 리스트 리턴
        2. 특정 채팅방의 메시지 리스트 리턴
        3. 새로운 메시지 저장
    */

    public function rooms() {
        return ChatRoom::all();
    }

    public function messages($roomId) {
        // select * from chat_messages where room_id = ?
        $msgs = ChatMessage::where('chat_room_id', $roomId)->with('user')->latest()->paginate(3);
        // lazy loading VS eager loading
        // dd($msgs);
        return $msgs;
    }

    public function newMessage(Request $request, $roomId) {
        $request->validate(['message' => 'required']);
        $msg = ChatMessage::create([
            'user_id' => auth()->user()->id,
            'chat_room_id' => $roomId,
            'message' => $request->message,
        ]);

        $msg->load('user');
        broadcast(new NewChatMessage($msg))->toOthers();
        return $msg;
    }
}
