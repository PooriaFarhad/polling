@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('polls.update', $poll->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('polls.partials._form')
            <button type="submit" class="btn btn-primary">
                Update
            </button>
        </form>
    </div>
@stop