<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\PostImage;
use Auth;
use Illuminate\Support\Facades\Storage;
use DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::with('post_images')->orderBy('created_at', 'desc')->get();
        return response()->json(['error' => false, 'data' => $posts]);
        // DB::connection('mongodb')       //选择使用mongodb
        //       ->collection('posts')           //选择使用users集合
        //       ->insert([                          //插入数据
        //         'id' => 1,
        //               'name'  =>  'tom', 
        //               'age'     =>   18
        //           ]);
        
        // dd(DB::connection('mongodb')->collection('posts')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('blog.add-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request->user());
        $user = Auth::user();
        $title = $request->title;
        $body = $request->body;
        $images = $request->images;

        $post = Post::create([
            'title' => $title,
            'body' => $body,
            'user_id' => $user->id,
        ]);

        foreach ($images as $image) {
            $imagePath = Storage::disk('uploads')->put($user->email . '/posts', $image);
            PostImage::create([
                'post_image_caption' => $title,
                'post_image_path' => '/uploads/' . $imagePath,
                'post_id' => $post->id,
            ]);
        }

        return response()->json(['error' => false, 'data' => $post]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $post = Post::with('post_images')->where('_id', $request->id)->first();
        return response()->json(['error' => false, 'data' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $post = Post::where('_id', $request->id)->first();
        return view('blog.add-edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
        $user = Auth::user();
        $title = $request->title;
        $body = $request->body;
        $images = $request->images;

        $post = Post::where('_id', $request->id)->first();
        $post->title = $title;
        $post->body = $body;
        $post->user_id = $user->id;
        $post->save();

        foreach ($images as $image) {
            dd($image, isset($image->post_image_path));
            if (isset($image->post_image_path)) {
                continue;
            }

            $imagePath = Storage::disk('uploads')->put($user->email . '/posts', $image);
            PostImage::create([
                'post_image_caption' => $title,
                'post_image_path' => '/uploads/' . $imagePath,
                'post_id' => $post->id,
            ]);
        }

        return response()->json(['error' => false, 'data' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        return Post::where('_id', $request->id)->delete();
    }
}
