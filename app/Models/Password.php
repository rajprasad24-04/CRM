<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Password extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'title', 'user_id', 'password', 'notes'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Automatically encrypt password on set
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Crypt::encryptString($value);
    }

    // Automatically decrypt password on get
    public function getPasswordAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}
