<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'is_active',
        'starts_at',
        'ends_at',
        'banner_path',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function likes(): HasMany
    {
        return $this->hasMany(NoticeLike::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(NoticeComment::class)->latest();
    }
}
