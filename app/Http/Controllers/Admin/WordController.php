<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\WordRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Word;
use App\Models\Option;
use App\Models\User;

class WordController extends Controller
{
    public function index()
    {
        $items = Word::with('options')->with('category')->paginate(config('settings.paginate_number'));
        $categories = Category::pluck('title', 'id')->toArray();

        return view('admin.wordlist.index', [
            'items' => $items,
            'categories' => $categories,
        ]);
    }

    public function store(WordRequest $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }

        $inputs = $request->only('options', 'category_id', 'word', 'description', 'answer');

        foreach ($inputs['options'] as $option) {
            $ans[] = [
                'option' => $option,
            ];
        }

        $word = Word::create([
            'category_id' => $inputs['category_id'],
            'word' => $inputs['word'],
            'description' => $inputs['description'],
            'answer' => $inputs['answer'],
        ])->options()->createMany($ans);

        if (!$word) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }

        return response()->json([
            'message' => trans('settings.success_message'),
        ]);
    }

    public function update(WordRequest $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }

        $inputs = $request->only('id', 'options', 'category_id', 'word', 'description', 'answer', 'idOptions');

        $answerId = Word::find($inputs['id'])->options()->get()->pluck('id');
        $answerIdDelete = [];
        foreach ($answerId as $id) {
            if (!in_array($id, $inputs['idOptions'])) {
                $answerIdDelete[] = $id;
            }
        }

        if ($answerIdDelete) {
            Option::whereIn('id', $answerIdDelete)->delete();
        }

        try {
            $word = Word::findOrFail($inputs['id']);
        } catch (ModelNotFoundException $ex) {
            return $ex;
        }

        $word->update([
            'category_id' => $inputs['category_id'],
            'word' => $inputs['word'],
            'description' => $inputs['description'],
            'answer' => $inputs['answer'],
        ]);
        foreach ($inputs['options'] as $key => $option) {
            Option::updateOrCreate(['word_id' => $inputs['id'], 'id' => $key], ['option' => $option]);
        }

        if (!$word) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }

        return response()->json([
            'message' => trans('settings.success_message'),
        ]);
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }

        $word = Word::where('id', $request->id)->delete();

        if (!$word) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }

        return response()->json([
            'message' => trans('settings.success_message'),
        ]);
    }

    public function wordContent(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }
        
        $checkAnswer = Word::where('id', $request->id)->pluck('answer');
        $answers = Option::where('word_id', $request->id)->get();
        
        if (!isset($request->numItems)){
            return view('admin.wordlist.content', [
                'checkAnswer' => $checkAnswer,
                'answers' => $answers,
            ])->render();
        }

        return view('admin.wordlist.content', [
            'numItems' => $request->numItems,
        ])->render();
    }
}
