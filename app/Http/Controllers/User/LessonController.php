<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\Word;
use App\Models\Activity;
use Auth;
use Carbon\Carbon;

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
    
    public function show($id)
    {
        $lesson = Lesson::where('id', $id)->with('category', 'test')->first();
        if (!isset($lesson) || $lesson->result) {
            return redirect()->action('HomeController@error404');
        }

        $createdAt = $lesson->created_at->format('Y-m-d G:i a');
        $categoryName = $lesson->category->title;
        $category = [$lesson->category->id];
        $timer = Carbon::now();
        $questionNumber = $lesson->test->question_number;

        $questions = Word::with('options')->whereIn('category_id', $category)
            ->take($questionNumber)->inRandomOrder()->get();
        
        return view('layouts.test', compact('questions', 'createdAt', 'categoryName', 'timer'));       
    }

    public function update(Request $request, $id)
    {
        $input = $request->only('word', 'time');
        if (!isset($input['word'])) {
            return redirect()->action('User\LessonController@index');
        }

        $start = Carbon::parse($input['time']);
        $end = Carbon::now();
        $hours = $start->diffInHours($end);
        $minutes = $start->diffInMinutes($end);
        $seconds = $start->diffInSeconds($end);
        $spentTime = Carbon::createFromTime($hours, $minutes, $seconds)->toTimeString();
        $result = $memories = config('settings.lesson.default_result');
        $words = Word::with('users')->get();

        foreach ($words as $word) {
            if (isset($input['word'][$word->id]) && $word->answer == $input['word'][$word->id]) {
                if ($word->users->isEmpty()) {
                    $word->users()->attach(Auth::user()->id);
                    ++$memories; 
                } 

                ++$result;                
            }                   
        }

        try {
            $lesson = Lesson::findOrFail($id);
        } catch (ModelNotFoundException $ex) {
            return $ex;
        }

        $lesson->update([
            'spent_time' => $spentTime,
            'result' => $result,
        ]);

        if ($result != config('settings.lesson.default_result')) {
            $inputActivities = [
                'user_id' => Auth::user()->id,
                'action_type' => 'lesson_' . $memories,
            ];
            $lesson->activity()->create($inputActivities);
        }

        $activityCategory = $this->addActivityCategory($lesson);

        return redirect()->action('User\LessonController@index');
    }

    protected function addActivityCategory($lesson)
    {
        $categoryId = $lesson->category()->first()->id;
        $learnedCategory = Auth::user()->words()->with('users')->where('category_id', $categoryId)->count();
        $wordCategory = Word::where('category_id', $categoryId)->count();
        $activityCategory = Auth::user()
            ->activities()
            ->where([ ['action_type', 'category'], ['action_id', $categoryId] ])
            ->first();
    
        if (!$activityCategory && $learnedCategory == $wordCategory) {
            $inputActivities = [
                'user_id' => Auth::user()->id,
                'action_id' => $categoryId,
                'action_type' => config('settings.action.type_category'),
            ];
            Activity::create($inputActivities);
        }

    }
}
