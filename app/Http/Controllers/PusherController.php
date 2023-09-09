<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;

class PusherController extends Controller
{
    public function sendMessage(Request $request, $id)
    {
        $return_data['response_code'] = 0;
        $return_data['message'] = 'Something went wrong, Please try again later.';

        $rules = ['message' => 'required'];
        $messages = ['message.required' => 'Please enter message to communicate.'];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = implode("
        ", $validator->messages()->all());
            $return_data['message'] = $message;
            return $return_data;
        }

        $data['message'] = $request->message;
        $data['sender_id'] = Auth::user()->id;
        $data['receiver_id'] = $id;

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:png,jpg,jpeg|max:2048',
            ]);

            $data['image'] = $request->image->store('public/chats');
            $data['image'] = str_replace("public/", "", $data['image']);
        }

        $dataStore = [
            'sender_id' => $data['sender_id'],
            'receiver_id' => $data['receiver_id'],
            'text' => $data['message'],
            'image' => $request->hasFile('image') ? $data['image'] : null
        ];

        // $data['name'] = Auth::user()->name;

        Chat::create($dataStore);

        $idroom = $request->idroom;
        // dd($data);

        try {
            $options = [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true
            ];

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );

            $response = $pusher->trigger(
                'room-' . $idroom,
                'my-event',
                $data
            );
            $this->sendNotif($data['receiver_id'], $data['message']);

            if ($response) {
                $return_data['response_code'] = 1;
                $return_data['message'] = 'Success.';
            }
        } catch (\Exception $e) {
            $return_data['message'] = $e->getMessage();
        }
        return $return_data;
    }

    public function sendNotif($idtujuan, $pesan)
    {
        $beamsClient = new \Pusher\PushNotifications\PushNotifications(array(
            "instanceId" => "cc807c3b-78f3-4bcb-812c-b3e37637df1c",
            "secretKey" => "210CA157170FDEAF8F822A282837CBDAA9B4BDA45929F9860606EA1858CF3A70",
        ));

        $user = User::find($idtujuan);

        $publishResponse = $beamsClient->publishToInterests(
            array($idtujuan),
            array(
                "web" => array("notification" => array(
                    "title" => "Pesan Baru dari " . $user->name,
                    "body" => $pesan,
                )),
            )
        );

        return $publishResponse;
    }
}
