@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Создать новую анкету</h1>
    <form action="{{ route('admin.surveys.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Название</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div id="questions-container">
            <div class="question-group">
                <div class="form-group">
                    <label for="questions[0][question_text]">Вопрос</label>
                    <input type="text" class="form-control" id="questions[0][question_text]" name="questions[0][question_text]" required>
                </div>
                <div class="form-group">
                    <label for="questions[0][type]">Тип вопроса</label>
                    <select class="form-control" id="questions[0][type]" name="questions[0][type]" required>
                        <option value="text">Текст</option>
                        <option value="radio">Радиокнопка</option>
                        <option value="checkbox">Чекбокс</option>
                    </select>
                </div>
                <div class="form-group options-group" style="display:none;">
                    <label>Варианты ответов</label>
                    <div class="option-group">
                        <input type="text" class="form-control" name="questions[0][options][]">
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary add-option">Добавить вариант</button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary add-question">Добавить вопрос</button>
        <button type="submit" class="btn btn-primary">Создать анкету</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let questionIndex = 0;

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