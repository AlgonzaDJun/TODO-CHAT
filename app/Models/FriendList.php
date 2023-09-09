<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'friend_id',

    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function friend()
    {
        return $this->hasOne(User::class, 'id', 'friend_id');
    }

    public function lastchat()
    {
        return $this->hasOne(Chat::class, 'sender_id', 'id');
    }
}
