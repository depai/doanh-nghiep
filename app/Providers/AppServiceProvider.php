<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend('path.public', function ($pathPublic, $app) {
            return $app['path.base'] . DIRECTORY_SEPARATOR . 'public_html';
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $categories = Category::with('childs', 'posts')->isParent()->get();
        View::share('categories', $categories);
        Schema::defaultStringLength(191);
    }
}
