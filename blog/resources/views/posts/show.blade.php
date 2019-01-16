@extends('layouts.app')

@section('content')



      <a href="/posts" class="btn btn-secondary">Back</a><br><br>
      <h1>{{ $post->title }}</h1>
      <img style="width:300px; height:200px" src="/storage/cover_images/{{$post->cover_image}}" > <br> <br>

      <p>{{$post->content}}</p>

      <small>Written On: {{$post->created_at}} <br>{{$post->user->name}}</small>
      <br><br>

      @if(!Auth::guest())
          @if(Auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a>

            {!! Form::open(['action'=>['PostsController@destroy', $post->id], 'method'=>'POST', 'class'=>'float-right']) !!}

            {{Form::hidden('_method','DELETE')}}
            {{Form::submit('Delete',['class'=>'btn btn-danger'])}}

            {!! Form::close() !!}
          @endif

      @endif
      <br><br>

      <h3 style="color:#476b6b">Comments</h3>


      @if(count($comments)>0)

        @foreach($comments as $sakib)
        @if($post->id == $sakib->post_id)
                <p><b>{{$sakib->comment}}</b></p>
                <small>Commented by {{$sakib->user->name}}</small>
            <br> <br>
              @endif
        @endforeach

      @else
      <h2>No Comments Found!</h2>
      @endif


  @if(!Auth::guest())


            {!! Form::open(['action'=>['CommentsController@store'], 'method'=>'POST']) !!}

            {{Form::text('comment', '',['class'=>'form-control p-4', 'placeholder'=>'Add Comment'])}} <br>
            {{Form::submit('Add Comment',['class'=>'btn btn-primary'])}}

            {!! Form::hidden('post_id', $post->id) !!}
            {!! Form::close() !!}

            <br><br>

@endif



@endsection
