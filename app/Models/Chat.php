<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'text',
        'image',
        'read',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'id', 'sender_id');
    }
}
