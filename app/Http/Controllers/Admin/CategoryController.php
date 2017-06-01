<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Category;
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
        
        $test = Test::where('category_id', $request->id)->delete();
        $category = Category::where('id', $request->id)->delete();

        if ($test && $category) {
            return response()->json([
                'message' => trans('settings.success_message'),
            ]);
        }

        return response()->json([
            'message' => trans('settings.error_message'),
        ]);
    }
}
