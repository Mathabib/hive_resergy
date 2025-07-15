<?php

namespace App\Http\Controllers;

use App\Models\ThemeSetting;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        // Ambil data dari DB (bisa null kalau belum ada)
        $theme = ThemeSetting::first();

        return view('generate.theme', compact('theme'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'sidebar_color' => 'nullable|string',
            'sidebar_theme' => 'nullable|string',
            'navbar_color' => 'nullable|string',
            'navbar_theme' => 'nullable|string',
            'footer_color' => 'nullable|string',
            'footer_theme' => 'nullable|string',
        ]);

        // Simpan atau update (satu record)
        $setting = ThemeSetting::first() ?? new ThemeSetting();
        $setting->fill($validated);
        $setting->save();

        return response()->json(['status' => 'success']);
    }
}
