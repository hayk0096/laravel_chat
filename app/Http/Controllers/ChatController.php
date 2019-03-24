<?php

namespace App\Http\Controllers;

use App\Room;
use App\Events\Message;
use App\Events\PrivateChat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPublicChatPage()
    {
        return view('chat');
    }

    /**
     * @param Room $room
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPrivateRoomPage(Room $room)
    {
        return view('room', compact('room'));
    }

    /**
     * @param Request $request
     */
    public function sendPublicMessage(Request $request)
    {
        Message::dispatch($request->all());
    }

    /**
     * @param Request $request
     */
    public function sendPrivateMessage(Request $request)
    {
        PrivateChat::dispatch($request->all());
    }

}
