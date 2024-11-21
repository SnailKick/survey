<?php
namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;

class AdminSurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::all();
        return view('admin.surveys.index', compact('surveys'));
    }

    public function create()
    {
        return view('admin.surveys.create');
    }

    public function store(Request $request)
    {
        $survey = Survey::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        foreach ($request->input('questions') as $questionData) {
            $question = $survey->questions()->create([
                'question_text' => $questionData['question_text'],
                'type' => $questionData['type'],
            ]);

            if ($question->type !== 'text') {
                foreach ($questionData['options'] as $optionText) {
                    $question->options()->create([
                        'option_text' => $optionText,
                    ]);
                }
            }
        }

        return redirect()->route('admin.surveys.index')->with('success', 'Анкета успешно создана!');
    }

    public function edit(Survey $survey)
    {
        return view('admin.surveys.edit', compact('survey'));
    }

    public function update(Request $request, Survey $survey)
    {
        $survey->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        $survey->questions()->delete();

        foreach ($request->input('questions') as $questionData) {
            $question = $survey->questions()->create([
                'question_text' => $questionData['question_text'],
                'type' => $questionData['type'],
            ]);

            if ($question->type !== 'text') {
                foreach ($questionData['options'] as $optionText) {
                    $question->options()->create([
                        'option_text' => $optionText,
                    ]);
                }
            }
        }

        return redirect()->route('admin.surveys.index')->with('success', 'Анкета успешно обновлена!');
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('admin.surveys.index')->with('success', 'Анкета успешно удалена!');
    }
}