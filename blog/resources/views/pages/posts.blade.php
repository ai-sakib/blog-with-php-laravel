@extends('layouts.app')

@section('content')

      <h1>Posts</h1>
      @if(count($posts) >0)

        @foreach($posts as $post)
          <div class="well">
            <h3>{{$post->title}}</h3>
          </div>
        @endforeach

      @else
      <h2>No Posts Found!</h2>
      @endif

@endsection
