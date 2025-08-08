<?php

// app/Models/Broadcasting.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Broadcasting extends Model
{
    protected $table = 'broadcast_logs'; // nama tabel di database
    protected $fillable = [
        'email', 'subject', 'message', 'attachment', 'status',
        'queued_at', 'sent_at', 'error_message'
    ];

    protected $casts = [
        'queued_at' => 'datetime',
        'sent_at'   => 'datetime',
    ];
}
