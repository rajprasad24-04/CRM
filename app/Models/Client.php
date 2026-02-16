<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_type',
        'family_code',
        'client_code',
        'family_head',
        'abbr', 
        'client_name', 
        'gender', 
        'pan_card_number',
        'dob',
        'doa',
        'date_of_join',
        'close_date',
        'category',
        'rm',
        'rm_user_id',
        'partner',
        'primary_mobile_number',
        'primary_email_number',
        'secondary_mobile_number',
        'secondary_email_number',
        'address',
        'city',
        'state',
        'zip_code',
        'referred_by',
        'tax_status',
        'notes',
    ];

    /**
     * A client can have many saved passwords (for different services).
     */
    public function passwords()
    {
        return $this->hasMany(Password::class);
    }

    /**
     * A client has one financial data record.
     */
    public function financialData()
    {
        return $this->hasOne(FinancialData::class);
    }

    public function relationshipManager()
    {
        return $this->belongsTo(User::class, 'rm_user_id');
    }
}
