@extends('layouts.main')

@section('title', 'Home page')

@section('content')
    <h1 class="h2">Dashboard page</h1>

    <div class="mb-3">
    <form method="post" action="dashboard/add_review">
            @csrf
        
            <label for="exampleFormControlInput1" class="form-label">Subject</label>
            <input type="text" class="form-control" name="subject" id="subject" placeholder="subject text">
        
        
            <label for="exampleFormControlTextarea1" class="form-label">Text of message</label>
            <textarea class="form-control" name="message" id="message" rows="8" placeholder="input message"></textarea> 
            <hr>

        <button type="submit" class="btn btn-success">Send</button>

    </form>
    </div>

    <h2>All reviews:</h2>
    <hr>
    @foreach($review as $el)
        <div>
            <br>{{ $el->subject }}</br>     
            <b> {{ $el->created_at }} User:</b>
            <b> {{ $el->email }}</b>
            <p> {{ $el->message }}</p>
            <hr>
        </div>
    @endforeach

@endsection