<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\FriendList;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendListController extends Controller
{
    public static function getFriend()
    {
        // $friend = FriendList::with('friend')->where('user_id', Auth::user()->id)->get();
        // $friend2 = FriendList::with('user')->where('friend_id', Auth::user()->id)->get();

        // $friends = new Collection();

        // foreach ($friend as $f) {
        //     $friends->push($f->friend);
        // }
        // foreach ($friend2 as $f) {
        //     $friends->push($f->user);
        // }

        // dump($friends);

        $friendsCollection = new Collection();
        $friendsAndLastChat = new Collection();

        if (Auth::check()) {
            $friends = FriendList::with(['friend', 'user', 'lastchat'])
                ->where(function ($query) {
                    $query->where('user_id', Auth::user()->id)
                        ->orWhere('friend_id', Auth::user()->id);
                })
                ->get();

            // foreach ($friends as $friend) {
            //     $chat = $friend->lastchat;
            //     dump($chat);
            // }
            $friendsCollection = $friends->map(function ($friend) {
                return $friend->user_id == Auth::user()->id
                    ? $friend->friend
                    : $friend->user;
            });

            $lastChat = $friendsCollection->map(function ($friend) {
                $lastChat = Chat::where([
                    ['sender_id', Auth::user()->id],
                    ['receiver_id', $friend->id]
                ])->orWhere([
                    ['sender_id', $friend->id],
                    ['receiver_id', Auth::user()->id]
                ])->latest()->first();

                return $lastChat;
            });

            $friendsAndLastChat = $friendsCollection->zip($lastChat)->map(function ($items) {
                list($friend, $lastChat) = $items;
                return [
                    'friend' => $friend,
                    'lastChat' => $lastChat,
                ];
            });
        }

        return $friendsAndLastChat;
        // die();
    }

    public function addFriend(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $search_friend = User::where('email', $request->email)->first();

        if(!$search_friend){
            return redirect('/add-friends')->with('error', 'Email not found');
        }
        
        FriendList::create([
            'user_id' => Auth::user()->id,
            'friend_id' => $search_friend->id,
        ]);

        return redirect('/add-friends')->with('success', 'Friend added successfully');
    }
}
