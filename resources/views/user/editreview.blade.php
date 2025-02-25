@extends('layouts.main')

@section('title', 'Edit review page')

@section('content')
    <h1 class="h2">Edit review page</h1>


    <div class="mb-3">
    <form method="post" enctype="multipart/form-data" action="editreview">
            @csrf
        
            <label for="exampleFormControlInput1" class="form-label">Subject</label>
            <input type="text" class="form-control" name="subject" id="subject" value="{{ $subject }}">
        
        
            <label for="exampleFormControlTextarea1" class="form-label">Text of message</label>
            <textarea class="form-control" name="message" id="message" rows="8">{{ $textreview }}</textarea> 

            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01">Upload</label>
                <input type="file" class="form-control" id="file" name="file">
            </div>

            <input type="hidden" name="id_review" id="id_review" value="{{ $id }}">
            
            <hr>

        <button type="submit" class="btn btn-success">Update</button>

    </form>
    </div>

    

@endsection