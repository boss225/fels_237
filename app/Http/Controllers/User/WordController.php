<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Word;
use App\Models\Category;
use App\Models\User;

class WordController extends Controller
{
    public function showList()
    {
        $words = Word::orderBy('word')->with('users')->paginate(config('settings.paginate_number'));

        return view('user.word.index', compact('words'));
    }

    public function wordsFilter(Request $request)
    {   
        $inputs = $request->only('key', 'arrange', 'rdOption');
        $filterArrange = $inputs['arrange'];
        $filterOption = $inputs['rdOption'];
        $filterKey = $inputs['key'];

        $words = $this->filter($inputs);

        return view('user.word.filter', compact('words', 'filterArrange', 'filterOption', 'filterKey'));
    }

    public function wordsCategory($id)
    {
        $categories = Category::find($id);
        $words = Word::where('category_id', $id)->orderBy('word')->with('users')->paginate(config('settings.paginate_number'));
        
        return view('user.word.index', compact('words', 'categories'));
    }

    public function wordsCategoryFilter(Request $request, $id)
    {   
        $inputs = $request->only('key', 'arrange', 'rdOption');
        $inputs['category_id'] = $id;
        $filterArrange = $inputs['arrange'];
        $filterOption = $inputs['rdOption'];
        $filterKey = $inputs['key'];
        $categories = Category::find($id);
        
        $words = $this->filter($inputs);

        return view('user.word.filter', compact('words', 'categories', 'filterArrange', 'filterOption', 'filterKey'));
    }

    protected function filter($inputs)
    {
        if (!isset($inputs['category_id'])) {
           $categories = Category::all()->pluck('id');
        } else {
           $categories = [$inputs['category_id']];
        }

        if ($inputs['arrange'] == 0) {
           $inputs['arrange'] = config('settings.filter.asc');
        } else {
           $inputs['arrange'] = config('settings.filter.desc');
        }

        if (!isset($inputs['rdOption'])) {
            $words = Word::with('users')->whereIn('category_id', $categories)
                ->where('word', 'like', '%' . $inputs['key'] . '%')->orderBy('word', $inputs['arrange'])->paginate(config('settings.paginate_number'));

        } elseif ($inputs['rdOption'] == config('settings.filter.learned')) {
            $words = auth()->user()->words()->with('users')->whereIn('category_id', $categories)
                ->where('word', 'like', '%' . $inputs['key'] . '%')->orderBy('word', $inputs['arrange'])->paginate(config('settings.paginate_number'));

        } else {
            $words = Word::with('users')->whereDoesntHave('users')->whereIn('category_id', $categories)
                ->where('word', 'like', '%' . $inputs['key'] . '%')->orderBy('word', $inputs['arrange'])->paginate(config('settings.paginate_number'));
        }

        return $words;
    }
}
