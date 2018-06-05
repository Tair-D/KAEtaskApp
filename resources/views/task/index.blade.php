@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($task_list as $task)
            <p>{{ $task->title }}</p>
        @endforeach
    </div>
@endsection
