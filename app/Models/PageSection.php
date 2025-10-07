<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'pageName',
        'sectionName',
        'sectionImage',
        'content',
        'is_active', 
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
