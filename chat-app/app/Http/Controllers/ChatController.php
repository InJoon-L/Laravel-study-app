<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    /*
        1. 채팅방 리스트 리턴
        2. 특정 채팅방의 메시지 리스트 리턴
        3. 새로운 메시지 저장
    */

    public function rooms() {

    }

    public function messages($roomId) {

    }

    public function newMessage(Request $request, $roomId) {

    }
}
