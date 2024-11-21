<?php
namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::all();
        return view('surveys.index', compact('surveys'));
    }

    public function show(Survey $survey)
    {
        return view('surveys.show', compact('survey'));
    }

    public function submit(Request $request, Survey $survey)
    {
        $user = Auth::user();

        foreach ($survey->questions as $question) {
            $answer = new Answer();
            $answer->question_id = $question->id;
            $answer->user_id = $user ? $user->id : null;

            if ($question->type === 'text') {
                $answer->answer_text = $request->input('question_' . $question->id);
            } else {
                $answer->option_id = $request->input('question_' . $question->id);
            }

            $answer->save();
        }

        return redirect()->route('surveys.index')->with('success', 'Ответы успешно сохранены!');
    }
}