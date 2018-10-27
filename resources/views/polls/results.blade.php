@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>
            {{ $poll->title }}
        </h1>
        @foreach($results as $result)
            <div class="result-item">
                <h2>
                    {{ $result->title }}
                </h2>
                <div class="float-right">
                    {{ $result->percentage }}%
                </div>
                <div class="percentage" style="width: {{ $result->percentage }}%"></div>
            </div>
        @endforeach
    </div>
@stop