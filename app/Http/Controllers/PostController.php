<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')
            ->only([
                'create',
                'store',
                'edit',
                'update',
                'destroy',
            ]);        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::connection()->enableQueryLog();
        // DB::enableQueryLog();

        // $posts = BlogPost::all();
        // $posts = BlogPost::with('comments')->get();

        // foreach ($posts as $post) {
        //     foreach ($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());
        // dd(BlogPost::withCount('comments')->get());
        return view('posts.index', [
            'posts' => BlogPost::latest()
                ->withCount('comments')
                ->with('user')
                ->get(),
            'mostCommented' => BlogPost::mostCommented()
                ->take(5)
                ->get(),
            'mostActive' => User::withMostBlogPosts()
                ->take(5)
                ->get(),
            'mostActiveLastMonth' => User::withMostBlogPostsLastMonth()
                ->take(5)
                ->get(),
        ]);
        // return view('posts.index', ['posts' => BlogPost::mostCommented()->withCount('comments')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize(BlogPost::class);
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $this->authorize(BlogPost::class);

        $validated = $request->validated();

        $validated['user_id'] = $request->user()->id;

        // $post = Auth::user()->blogPosts()->create($validated);
        $post = BlogPost::create($validated);
    
        // $post = new BlogPost();
        // $post->title = $validated['title'];
        // $post->content = $validated['content'];
        // $post->save();

        $request->session()->flash('status', 'The blog post was created successfully');

        return redirect()->route('posts.show', [ 'post' => $post->id ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return view('posts.show', [
        //     'post' => BlogPost::with(['comments' => function ($query) {
        //         return $query->latest();
        //     }])->findOrFail($id),
        // ]);

        return view('posts.show', ['post' => BlogPost::with('comments')->findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $post = BlogPost::findOrFail($id);

        $this->authorize($post);
        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog post.");
        // }

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);
        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog post.");
        // }

        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'The blog post was updated successfully');

        return redirect()->route('posts.show', [ 'post' => $post->id ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);

        // if (Gate::denies('delete-post', $post)) {
        //     abort(403, "You can't delete this blog post.");
        // }

        $post->delete();

        session()->flash('status', 'The blog post was deleted successfully');

        return redirect()->route('posts.index');
    }
}
