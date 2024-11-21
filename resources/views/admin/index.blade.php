@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Управление анкетами</h1>
    <a href="{{ route('admin.surveys.create') }}" class="btn btn-primary">Создать новую анкету</a>
    <table class="table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Описание</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surveys as $survey)
                <tr>
                    <td>{{ $survey->title }}</td>
                    <td>{{ $survey->description }}</td>
                    <td>
                        <a href="{{ route('admin.surveys.edit', $survey) }}" class="btn btn-sm btn-primary">Редактировать</a>
                        <form action="{{ route('admin.surveys.destroy', $survey) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection