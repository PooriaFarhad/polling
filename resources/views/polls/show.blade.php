@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>
            {{ $poll->title }}
        </h1>

        <form action="{{ route('polls.options.vote', $poll->id) }}" method="POST">
            @csrf
            @foreach($pollOptions as $pollOption)
                <div class="form-check">
                    <input name="option_id" class="form-check-input" type="radio" value="{{ $pollOption->id }}" id="{{ $pollOption->id }}">
                    <label for="{{ $pollOption->id }}">
                        {{ $pollOption->title }}
                    </label>
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">
                VOTE
            </button>
        </form>
    </div>
@stop