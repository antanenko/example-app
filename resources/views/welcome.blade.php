@extends('layouts.main')

@section('title', 'Home page')

@section('content')
    <h1 class="h2">Home page</h1>

    <h4 class="h4">Number of review:{{ $num_review }}</h4>

    <p>All reviews:</p>
    <hr>
    @foreach($all_review as $el)
        <div>
            <br>{{ $el->subject }}</br>     
            <b> {{ $el->created_at }} Author: {{ $el->email }}</b>
            <p> {{ $el->message }}</p>
            <hr>
        </div>
    @endforeach

@endsection