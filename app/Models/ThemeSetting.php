<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    protected $fillable = [
        'sidebar_color',
        'sidebar_theme',
        'navbar_color',
        'navbar_theme',
        'footer_color',
        'footer_theme',
    ];

    public $timestamps = false; // kalau tabelnya gak ada created_at & updated_at
}
