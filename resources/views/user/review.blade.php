@extends('layouts.main')

@section('title', 'Home page')

@section('content')
    <h1 class="h2">Review page</h1>

    <hr>
    
        <div>
                    
            <b> {{ $subject }}</b>
            <p> {{ $textreview }}</p>

            <img src="/storage/{{ $filePath }}" class="img-thumbnail" alt="...">

                      
        </div>
        <hr>
        <a href="{{ route('home') }}">Home</a>     


@endsection