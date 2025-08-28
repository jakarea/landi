<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name','code','admin_id','avatar','updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Old code
    // public function participants()
    // {
    //     return $this->belongsToMany(User::class, 'group_participants', 'group_id', 'user_id');
    // }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }


    // New Code
    public function participants()
    {
        return $this->hasMany(GroupParticipant::class, 'group_id');
    }

}
