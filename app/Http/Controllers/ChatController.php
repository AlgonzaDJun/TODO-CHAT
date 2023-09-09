<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\FriendList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $friend = FriendListController::getFriend();
        // dd($friend);
        return view('chat.index', [
            'friends' => $friend
        ]);
    }

    public function room($id)
    {
        $idroom = FriendList::with('friend')->where([
            ['friend_id', $id],
            ['user_id', Auth::user()->id]
        ])->first();
        if ($idroom) {
            $receiver = $idroom->friend;
        }
        if (!$idroom) {
            $idroom = FriendList::with('user')->where([
                ['friend_id', Auth::user()->id],
                ['user_id', $id]
            ])->first();
            $receiver = $idroom->user;
        }

        $chat = Chat::where([
            ['sender_id', Auth::user()->id],
            ['receiver_id', $id]
        ])->orWhere([
            ['sender_id', $id],
            ['receiver_id', Auth::user()->id]
        ])->get();


        return view('chat.room', [
            'idroom' => $idroom,
            'receiver_id' => $id,
            'receiver_detail' => $receiver,
            'chat' => $chat
        ]);
    }

    public function addFriends()
    {
        return view('chat.add-friends');
    }
}
