<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lesson;


class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('user', 'category')->paginate(config('settings.paginate_number'));

        return view('admin.lesson.index', compact('lessons'));
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }
        
        $lesson = Lesson::where('id', $request->id)->delete();

        if (!$lesson) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }

        return response()->json([
            'message' => trans('settings.success_message'),
        ]);
    }
}
