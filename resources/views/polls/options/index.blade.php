@extends('layouts.app')

@section('content')
    <div class="container">
    @include('includes.errors')
    @if($pollOption)
            <form action="{{ route('polls.options.update', [$poll->id, $pollOption->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">
                        Option Title
                    </label>
                    <input type="text" id="title" class="form-control" name="title" value="{{ old('title', isset($pollOption->title) ? $pollOption->title : null) }}">
                </div>
                <button type="submit" class="btn btn-primary">
                    Update
                </button>
            </form>
    @else
    <form action="{{ route('polls.options.store', $poll->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">
                Option Title
            </label>
            <input type="text" id="title" class="form-control" name="title" value="{{ old('title', isset($pollOption->title) ? $pollOption->title : null) }}">
        </div>
        <button type="submit" class="btn btn-primary">
            Add Option
        </button>
    </form>
    @endif

    @if(!$pollOptions->isEmpty())
        <table class="options-table table">
            <thead class="table-dark">
                <tr>
                    <th>
                        Option Title
                    </th>
                    <th>
                        Action
                    </th>
                    <th>

                    </th>
                </tr>

            </thead>
            <tbody>
            @foreach($pollOptions as $pollOption)
                <tr>
                    <td>
                        {{ $pollOption->title }}
                    </td>
                    <td>
                        <form action="{{ route('polls.options.destroy', [$poll->id, $pollOption->id]) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger" type="submit">
                                Remove
                            </button>
                        </form>
                    </td>
                    <td>
                        <a class="btn btn-light" href="{{ route('polls.options.index', [$poll->id, $pollOption->id]) }}">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @else
    There is no option yet.
    @endif
    </div>
@stop