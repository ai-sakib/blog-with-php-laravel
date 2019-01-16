@extends('layouts.app')

@section('content')

      <h1>Create Post</h1>
      {!! Form::open(['action'=>'PostsController@store', 'method'=>'POST', 'enctype'=> 'multipart/form-data']) !!}

          <div class="form-group">
            {{Form::label('title','Title')}}
            {{Form::text('title', '',['class'=>'form-control w-75 p-3', 'placeholder'=>'Title'])}}

          </div>

          <div class="form-group">
            {{Form::label('body','Body')}}
            {{Form::textarea('body', '',['class'=>'form-control w-75 p-3', 'placeholder'=>'Body'])}}

          </div>

          <div class="form-group">
            {{Form::file('cover_image')}}

          </div>

          {{Form::submit('Submit',['class'=>'btn btn-primary'])}}

      {!! Form::close() !!}


@endsection
