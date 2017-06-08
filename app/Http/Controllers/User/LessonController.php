<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\Test;
use Auth;

class LessonController extends Controller
{
    public function index()
    {   
        $categories = Category::with('test')->get()->pluck('title', 'test.id');
        $lessons = Lesson::where('user_id', Auth::user()->id)->with('category', 'test')->paginate(config('settings.paginate_number'));

        return view('user.lesson.index', [
            'categories' => $categories,
            'lessons' => $lessons,
        ]);
    }

    public function store(Request $request)
    {   
        $input = $request->only('test_id');
        $lesson = Lesson::create([
            'user_id' => Auth::user()->id,
            'test_id' => $input['test_id'],
            'result' => config('settings.lesson.default_result'),
            'spent_time' => config('settings.lesson.default_time'),
        ]);
        
        if (!$lesson) {
            return redirect()->action('User\LessonController@index')
               ->with('status', 'danger')
               ->with('message', config('settings.message_fail'));
        }

        return redirect()->action('User\LessonController@index');
    }
}
