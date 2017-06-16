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
        $items = Word::with('options')->with('category')->get();
        $categories = Category::pluck('title', 'id')->toArray();

        return view('admin.wordlist.index', [
            'items' => $items,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $categories = Category::pluck('title', 'id')->toArray();

        return view('admin.wordlist.create', compact('categories'));
    }

    public function store(WordRequest $request)
    {
        $inputs = $request->only('answer', 'category_id', 'word', 'description', 'check_answer');

        foreach ($inputs['answer'] as $index => $option) {
            if ($index == $inputs['check_answer']) {
                $inputs['check_answer'] = $option;
            }

            $ans[] = [
                'option' => $option,
            ];
        }

        $word = Word::create([
            'category_id' => $inputs['category_id'],
            'word' => $inputs['word'],
            'description' => $inputs['description'],
            'answer' => $inputs['check_answer'],
        ])->options()->createMany($ans);

        if (!$word) {
            return redirect()->back()
                ->with('status', 'danger')
                ->with('message', trans('settings.error_message'));
        }

        return redirect()->action('Admin\WordController@index')
            ->with('status', 'success')
            ->with('message', trans('settings.success_message'));
    }

    public function edit($id)
    {
        $word = Word::find($id);
        if (!$word) {
            return redirect()->action('HomeController@error404');
        }

        $categories = Category::pluck('title', 'id')->toArray();
        $answers = Option::where('word_id', $id)->get();

        return view('admin.wordlist.edit', compact('word', 'categories', 'answers'));
    }

    public function update(WordRequest $request, $id)
    {
        $inputs = $request->only('category_id', 'word', 'description', 'answer', 'check_answer');

        try {
            $word = Word::findOrFail($id);
        } catch (ModelNotFoundException $ex) {
            return $ex;
        }

        $answerId =  $word->options()->get()->pluck('id');
        $answerIdDelete = [];
        foreach ($answerId as $aId) {
            if (!in_array($aId, array_keys($inputs['answer']))) {
                $answerIdDelete[] = $aId;
            }
        }

        if ($answerIdDelete) {
            Option::whereIn('id', $answerIdDelete)->delete();
        }

        foreach (array_values($request->answer) as $index => $option) {
            if ($index == $inputs['check_answer']) {
                $inputs['check_answer'] = $option['ans'];
            }
        }

        $word->update([
            'category_id' => $inputs['category_id'],
            'word' => $inputs['word'],
            'description' => $inputs['description'],
            'answer' => $inputs['check_answer'],
        ]);
        
        foreach ($inputs['answer'] as $key => $option) {
            Option::updateOrCreate(['word_id' => $id, 'id' => $key], ['option' => $option['ans']]);
        }
        
        if (!$word) {
            return redirect()->back()
                ->with('status', 'danger')
                ->with('message', trans('settings.error_message'));
        }

        return redirect()->action('Admin\WordController@index')
            ->with('status', 'success')
            ->with('message', trans('settings.success_message'));
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

        if (!isset($request->numItems)){
            return view('admin.wordlist.content', [
                'numEdit' => $request->numEdit,
            ])->render();
        }

        return view('admin.wordlist.content', [
            'numItems' => $request->numItems,
        ])->render();
    }
}
