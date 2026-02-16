<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialData extends Model
{
    use HasFactory;

    protected $table = 'financial_data';

    protected $fillable = [
        'life',
        'health',
        'pa',
        'critical',
        'motor',
        'general',
        'fd',
        'mf',
        'pms',
        'income_tax',
        'gst',
        'accounting',
        'others',
        'tds',
        'pt',
        'vat',
        'roc',
        'cma',
    ];

     // Define the inverse relationship with the Client model
     public function client()
     {
         return $this->belongsTo(Client::class);
     }
}
