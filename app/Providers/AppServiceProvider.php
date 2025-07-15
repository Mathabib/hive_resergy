<?php

namespace App\Providers;
use App\Models\Project;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
// public function boot(): void
// {
//     // Kirim daftar project ke semua view
//     View::composer('*', function ($view) {
//         if (Auth::check()) {
//             $projects = Auth::user()->role === 'admin'
//                 ? \App\Models\Project::all()
//                 : Auth::user()->projects;

//             $view->with('projects_sidebar', $projects);
//         } else {
//             $view->with('projects_sidebar', collect()); // kosong kalau belum login
//         }

//         // ✅ Kirim theme setting ke semua view
//         $themeSetting = \App\Models\ThemeSetting::first();
//         $view->with('themeSetting', $themeSetting);
//     });
// }

public function boot(): void
{
    // Kirim daftar project ke semua view
    View::composer('*', function ($view) {
        if (Auth::check()) {
            $projects = Auth::user()->role === 'admin'
                ? \App\Models\Project::all()
                : Auth::user()->projects;

            $view->with('projects_sidebar', $projects);

            // ✅ Kirim user yang login
            $view->with('user', Auth::user());
        } else {
            $view->with('projects_sidebar', collect()); // kosong kalau belum login
            $view->with('user', null); // user null kalau belum login
        }

        // ✅ Kirim theme setting ke semua view
        $themeSetting = \App\Models\ThemeSetting::first();
        $view->with('themeSetting', $themeSetting);
    });
}



}
