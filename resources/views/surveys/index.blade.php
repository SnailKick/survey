@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Доступные анкеты</h1>
    <ul>
        @foreach ($surveys as $survey)
            <li><a href="{{ route('surveys.show', $survey) }}">{{ $survey->title }}</a></li>
        @endforeach
    </ul>
</div>
@endsection