@extends('layouts.main')

@section('title', 'Home page')

@section('content')
    <h1 class="h2">Review page</h1>

    <hr>
    
        <div>
                    
            <b> {{ $subject }}</b>
            <p> {{ $textreview }}</p>

            
                <img src="/storage/{{ $filePath }}" width="600" alt="...">
            

                      
        </div>
        <hr>
        <a href="{{ route('home') }}">Home</a>  
        
        


        @auth
            <p>Пользователь залогинен: {{ Auth::user()->name }} User id:{{ Auth::user()->id }}</p>
            <p>User id review:{{ $user_id_review }}</p>

            @if($user_id_review == Auth::user()->id)
                <a href="/editreview/{{ $id }}">Edit review</a> 
            @endif

            
        @else
            <p>Пользователь не залогинен</p>
        @endauth


@endsection