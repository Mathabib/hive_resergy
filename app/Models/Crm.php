<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crm extends Model
{
    use HasFactory;

    protected $table = 'crm';

    protected $fillable = [
        'category',
        'name',
        'company',
        'email',
        'address',
        'notes',
        'phone',
        'website'
    ];
}
