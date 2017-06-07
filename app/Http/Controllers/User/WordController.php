<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Word;
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

        if ($inputs['arrange'] == 0) {
           $inputs['arrange'] = config('settings.filter.asc');
        } else {
           $inputs['arrange'] = config('settings.filter.desc');
        }

        if (!isset($inputs['rdOption'])) {
            $words = Word::where('word', 'like', '%' . $inputs['key'] . '%')
                ->orderBy('word', $inputs['arrange'])->with('users')->paginate(config('settings.paginate_number'));

        } elseif ($inputs['rdOption'] == config('settings.filter.learned')) {
            $words = auth()->user()->words()->orderBy('word', $inputs['arrange'])->where('word', 'like', '%' . $inputs['key'] . '%')
                ->with('users')->paginate(config('settings.paginate_number'));

        } else {
            $words = Word::with('users')->whereDoesntHave('users')->where('word', 'like', '%' . $inputs['key'] . '%')
                ->orderBy('word', $inputs['arrange'])->paginate(config('settings.paginate_number'));
        }

        return view('user.word.filter', compact('words', 'filterArrange', 'filterOption', 'filterKey'));
    }
}
