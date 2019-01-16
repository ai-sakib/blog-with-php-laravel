<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Comment;
use DB;

class PostsController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::orderBy('created_at','desc')->get();
        return view('posts.index', compact('posts'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
          'title'=> 'required',
          'body'=> 'required',
          'cover_image' => 'image|nullable|max:1999',

        ]);


        //File Uploding
        if($request->hasFile('cover_image')){

          $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
          $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('cover_image')->getClientOriginalExtension();
          $fileNameToStore = $fileName.'_'.time().'.'.$extension;
          $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);


        } else {

          $fileNameToStore = 'noimage.jpg';
        }


        $post = new Post;
        $post->title = $request->input('title');
        $post->content = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;

        $post->save();

        // $comment = new Comment;
        // $comment->comment = $request->input('comment');
        // $comment->user_id = auth()->user()->id;
        // $comment_name = $comment->comment;
        // $comment->save();



        return redirect('/posts')->with('success','Post Created Successfully !');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $comments = Comment::orderBy('created_at','desc')->get();
        return view('posts.show', compact('post','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        if(auth()->user()->id !== $post->user_id){
          return redirect('/posts')->with('error', 'You are not logged in !');

        }
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request,[
        'title'=> 'required',
        'body'=> 'required',
        'cover_image' => 'image|nullable|max:1999',

      ]);

      //File Uploding
      if($request->hasFile('cover_image')){

        $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('cover_image')->getClientOriginalExtension();
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;
        $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);


      }

      $post = Post::find($id);
      $post->title = $request->input('title');
      $post->content = $request->input('body');
      if($request->hasFile('cover_image')){
        $post->cover_image = $fileNameToStore;

      }
      $post->save();

      return redirect('/posts')->with('success','Post Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $post = Post::find($id);

      if(auth()->user()->id !== $post->user_id){
        return redirect('/posts')->with('error', 'You are not logged in !');

      }

      if($post->cover_image != 'noimage.jpg'){
        Storage::delete('public/cover_images/'.$post->cover_image);
      }

      $post->delete();
      return redirect('/posts')->with('success','Post Removed Successfully !');


    }
}
