@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('polls.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('polls.partials._form')
            <button type="submit" class="btn-margin btn btn-primary">
                Create
            </button>
        </form>
    </div>
@stop