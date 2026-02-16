<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'notice_id',
        'user_id',
    ];
}
