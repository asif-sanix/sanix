<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\user\category;
use App\Model\user\post;
use App\Model\user\tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $posts = post::all();
        return view('admin.posts.show',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('post.create')){
            $tags = tag::all();
            $categories = category::all();
            return view('admin.posts.add', compact('tags','categories')); 
        }
        return redirect(route('admin.home'));
          
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
         'title' => 'required',
         'subtitle' => 'required',
         'slug' => 'required',
         'body' => 'required',

        ]);

        if($request->hasFile('image')){
             $fileName=$request->image->getClientOriginalName();
            $imageName=$request->image->storeAs('public',$fileName);
         }

        $post = new post;
        $post->image = $imageName;
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->slug = $request->slug; 
        $post->body = $request->body; 
        $post->status = $request->status; 
        $post->save(); 

        $post->tags()->sync($request->tags);
        $post->categories()->sync($request->categories);


        return redirect(route('post.index')); 
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
         if(Auth::user()->can('post.create')){
        $post = post::with('tags','categories')->where('id',$id)->first();

        $tags = tag::all();
        $categories = category::all();
        return view('admin.posts.edit', compact('tags','categories','post'));
      }
         return redirect(route('admin.home'));
       //return view('admin.posts.edit', compact('post'));
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
        //
         $this->validate($request, [
         'title' => 'required',
         'subtitle' => 'required',
         'slug' => 'required',
         'body' => 'required',

        ]);

         if($request->hasFile('image')){
           // return $request->image->getClientOriginalName()->store('public');
            $imageName=$request->image->store('public');
         }

        $post = post::find($id);
        $post->image = $imageName;
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->slug = $request->slug; 
        $post->body = $request->body; 
         $post->status = $request->status;
        $post->tags()->sync($request->tags);
        $post->categories()->sync($request->categories);

        $post->save(); 

        return redirect(route('post.index')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        post::where('id',$id)->delete();
        return redirect()->back();
    }
}
