@extends('layouts.app')

@section('content')



      <h2>Comments</h2>
      @if(count($comments) >0)

        @foreach($comments as $comment)
                <p>{{$comment->comment}}</p>
                <small>Commented by {{$comment->user->name}}</small>
            <br> <br>
        @endforeach

      @else
      <h2>No Comments Found!</h2>
      @endif




@endsection
