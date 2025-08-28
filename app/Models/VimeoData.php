<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VimeoData extends Model
{
    use HasFactory;

    protected $table = 'vimeo_data';

    protected $fillable = [
        'client_id',
        'client_secret',
        'access_key',
        'user_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = auth()->user()->id;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
