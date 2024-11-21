@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $survey->title }}</h1>
    <p>{{ $survey->description }}</p>

    <form action="{{ route('surveys.submit', $survey) }}" method="POST">
        @csrf
        @foreach ($survey->questions as $question)
            <div class="form-group">
                <label for="question_{{ $question->id }}">{{ $question->question_text }}</label>
                @if ($question->type === 'text')
                    <input type="text" class="form-control" id="question_{{ $question->id }}" name="question_{{ $question->id }}">
                @elseif ($question->type === 'radio')
                    @foreach ($question->options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question_{{ $question->id }}" id="option_{{ $option->id }}" value="{{ $option->id }}">
                            <label class="form-check-label" for="option_{{ $option->id }}">
                                {{ $option->option_text }}
                            </label>
                        </div>
                    @endforeach
                @elseif ($question->type === 'checkbox')
                    @foreach ($question->options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="question_{{ $question->id }}[]" id="option_{{ $option->id }}" value="{{ $option->id }}">
                            <label class="form-check-label" for="option_{{ $option->id }}">
                                {{ $option->option_text }}
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>
@endsection