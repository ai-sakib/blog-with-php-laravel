@extends('layouts.app')

@section('content')

      <h1>Edit Post</h1>
      {!! Form::open(['action'=>['PostsController@update', $post->id], 'method'=>'POST', 'enctype'=> 'multipart/form-data']) !!}

          <div class="form-group">
            {{Form::label('title','Title')}}
            {{Form::text('title', $post->title,['class'=>'form-control w-75 p-3', 'placeholder'=>'Title'])}}

          </div>

          <div class="form-group">
            {{Form::label('body','Body')}}
            {{Form::textarea('body', $post->content,['class'=>'form-control w-75 p-3', 'placeholder'=>'Body'])}}

          </div>

          <div class="form-group">
            {{Form::file('cover_image')}}

          </div>


          {{Form::hidden('_method','PUT')}}

          {{Form::submit('Update',['class'=>'btn btn-primary'])}}

      {!! Form::close() !!}


@endsection
