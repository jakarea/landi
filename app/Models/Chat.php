<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = ['sender_id', 'receiver_id','group_id', 'message','file','file_extension','file_type','message_type', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function groupUserName()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }


}
