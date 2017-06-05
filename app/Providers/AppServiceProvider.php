<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Relationship;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.layout', function($view) {
            $categories = Category::all();
            $numberFollowers = Auth::user()->followers()->count();
            $numberFollowings = Auth::user()->followings()->count();
            $memoriedWord = Auth::user()->words()->count();
            $view->with('categories', $categories);
            $view->with('followers', $numberFollowers);
            $view->with('followings', $numberFollowings);
            $view->with('memoriedWord', $memoriedWord);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
