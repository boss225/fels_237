<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Activity;
use App\Models\Lesson;
use App\Models\Test;

class CategoryController extends Controller
{
    public function index()
    {
        $items = Category::with('test')->withCount('words')->get();

        return view('admin.category.index', compact('items'));
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }

        $checkCategory = Category::where('title', $request->title)->get();
        if (count($checkCategory) > 0) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }

        $test = new Test([
            'question_number' => $request->question_number,
        ]);
        $category = Category::create([
            'title' => $request->title,
        ]);
        $test->category()->associate($category);
        if ($test->save()) {
            return response()->json([
                'message' => trans('settings.success_message'),
            ]);
        }

        return response()->json([
            'message' => trans('settings.error_message'),
        ]);
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }

        try {
            $category = Category::findOrFail($request->id);
        } catch (ModelNotFoundException $ex) {
            return $ex;
        }

        $category->update([
            'title' => $request->title,
        ]);
        $test = Test::where('category_id', $category->id)
            ->update([
                'question_number' => $request->question_number,
            ]);
        
        if ($test && $category) {
            return response()->json([
                'message' => trans('settings.success_message'),
            ]);
        }

        return response()->json([
            'message' => trans('settings.error_message'),
        ]);
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }

        $category = Category::where('id', $request->id)->delete();
        $activity = Activity::where('action_id', $request->id)->where('action_type', 'like', '%category%')->delete();
        $actionId = Activity::where('action_type', 'like', '%lesson%')->pluck('action_id');
        
        if ($activity && $category) {
            foreach ($actionId as $value) {
                if (empty(Lesson::find($value))) {
                    Activity::where('action_id', $value)->where('action_type', 'like', '%lesson%')->delete();
                }
            }

            return response()->json([
                'message' => trans('settings.success_message'),
            ]);
        }

        return response()->json([
            'message' => trans('settings.error_message'),
        ]);
    }
}
