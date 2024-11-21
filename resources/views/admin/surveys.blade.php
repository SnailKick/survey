@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать анкету</h1>
    <form action="{{ route('admin.surveys.update', $survey) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Название</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $survey->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea class="form-control" id="description" name="description">{{ $survey->description }}</textarea>
        </div>
        <div id="questions-container">
            @foreach ($survey->questions as $index => $question)
                <div class="question-group">
                    <div class="form-group">
                        <label for="questions[{{ $index }}][question_text]">Вопрос</label>
                        <input type="text" class="form-control" id="questions[{{ $index }}][question_text]" name="questions[{{ $index }}][question_text]" value="{{ $question->question_text }}" required>
                    </div>
                    <div class="form-group">
                        <label for="questions[{{ $index }}][type]">Тип вопроса</label>
                        <select class="form-control" id="questions[{{ $index }}][type]" name="questions[{{ $index }}][type]" required>
                            <option value="text" {{ $question->type === 'text' ? 'selected' : '' }}>Текст</option>
                            <option value="radio" {{ $question->type === 'radio' ? 'selected' : '' }}>Радиокнопка</option>
                            <option value="checkbox" {{ $question->type === 'checkbox' ? 'selected' : '' }}>Чекбокс</option>
                        </select>
                    </div>
                    <div class="form-group options-group" style="{{ $question->type === 'text' ? 'display:none;' : '' }}">
                        <label>Варианты ответов</label>
                        @foreach ($question->options as $optionIndex => $option)
                            <div class="option-group">
                                <input type="text" class="form-control" name="questions[{{ $index }}][options][]" value="{{ $option->option_text }}">
                            </div>
                        @endforeach
                        <button type="button" class="btn btn-sm btn-secondary add-option">Добавить вариант</button>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-secondary add-question">Добавить вопрос</button>
        <button type="submit" class="btn btn-primary">Обновить анкету</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let questionIndex = {{ count($survey->questions) - 1 }};

        document.querySelector('.add-question').addEventListener('click', function () {
            questionIndex++;
            const questionGroup = document.querySelector('.question-group').cloneNode(true);
            questionGroup.innerHTML = questionGroup.innerHTML.replace(/\[0\]/g, `[${questionIndex}]`);
            document.querySelector('#questions-container').appendChild(questionGroup);
        });

        document.querySelector('#questions-container').addEventListener('change', function (event) {
            if (event.target.name.includes('[type]')) {
                const questionGroup = event.target.closest('.question-group');
                const optionsGroup = questionGroup.querySelector('.options-group');
                if (event.target.value === 'text') {
                    optionsGroup.style.display = 'none';
                } else {
                    optionsGroup.style.display = 'block';
                }
            }
        });

        document.querySelector('#questions-container').addEventListener('click', function (event) {
            if (event.target.classList.contains('add-option')) {
                const optionGroup = event.target.closest('.options-group');
                const newOption = optionGroup.querySelector('.option-group').cloneNode(true);
                newOption.querySelector('input').value = '';
                optionGroup.insertBefore(newOption, event.target);
            }
        });
    });
</script>
@endsection