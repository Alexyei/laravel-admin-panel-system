<?php

namespace App\Providers;

use App\Http\View\Composers\CategoriesWithCountComposer;
use App\Http\View\Composers\CategoryComposer;
use App\Http\View\Composers\TagComposer;
use App\Http\View\Composers\TagsWithCountComposer;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //setlocale(LC_TIME, "russian");
        $locale ='ru';
        $locale_CODE ='ru_RU';
        setlocale(LC_ALL, $locale . '.utf-8', $locale_CODE . '.utf-8', $locale, $locale_CODE);
        Paginator::useBootstrap();

        View::composer(['backend.post.create','backend.post.edit'], TagComposer::class);
        View::composer(['backend.post.create','backend.post.edit'], CategoryComposer::class);

        View::composer(['frontend.main','frontend.post'], CategoriesWithCountComposer::class);
        View::composer(['frontend.main','frontend.post'], TagsWithCountComposer::class);

        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->role==='admin';
        });



    }
}
