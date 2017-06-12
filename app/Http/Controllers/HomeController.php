<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\Activity;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::pluck('title', 'id');
        $userId = Auth::user()->followings()->get()->pluck('id');

        $lessons = Lesson::with('category')->where('user_id', Auth::user()->id)->get();     
        $userActivities = Auth::user()->activities()->orderBy('id', config('settings.filter.desc'))->get();

        $userFollowLessons = Lesson::with('category')->whereIn('user_id', $userId)->get();        
        $userFollowActivities = Activity::with('user')
            ->whereIn('user_id', $userId)
            ->orderBy('id', config('settings.filter.desc'))
            ->get();

        return view('home', [
            'userActivities' => $userActivities, 
            'lessons' => $lessons, 
            'userFollowActivities' => $userFollowActivities, 
            'userFollowLessons' => $userFollowLessons, 
            'categories' => $categories,
        ]);
    }
    
    public function error404()
    {
        return view('error.404');
    }
}
