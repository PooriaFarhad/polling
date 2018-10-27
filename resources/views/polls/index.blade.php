@extends('layouts.app')

@section('content')
    <div class="container">
        @if(!$polls->isEmpty())
            <table class="table">
                <thead class="">
                <tr>
                    <th>
                        Title
                    </th>
                    <th>
                        Action
                    </th>
                    <th>

                    </th>
                    <th>

                    </th>
                    <th>

                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($polls as $poll)
                    <tr>
                        <td>
                            <a href="{{ route('polls.show', $poll->id) }}">{{ $poll->title }}</a>
                        </td>
                        <td>
                            <form action="{{ route('polls.destroy', $poll->id) }}" method="POST">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    Remove
                                </button>
                            </form>
                        </td>
                        <td>
                            <a class="btn btn-secondary" href="{{ route('polls.edit', $poll->id) }}">
                                Edit
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('polls.options.index', $poll->id) }}">
                                Manage Options
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('polls.toggle', $poll->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                @if($poll->is_active)
                                    <button type="submit" class="btn btn-warning">Deactivate</button>
                                @else
                                    <button type="submit" class="btn btn-success">Activate</button>
                                @endif
                            </form>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
    </div>
@stop