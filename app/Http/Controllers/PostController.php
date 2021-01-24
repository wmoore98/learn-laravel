<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
        return view('posts.index', [
            'posts' => BlogPost::latest()
                ->withCount('comments')
                ->with('user')
                ->with('tags')
                ->get(),
        ]);
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
        $post = BlogPost::create($validated);
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
        $blogPost = Cache::remember("blog-post-{$id}", 60, function () use ($id) {
            return BlogPost::with('comments', 'user', 'tags', 'comments.user')
                ->findOrFail($id);
        });

        $sessionId = session()->getId();
        $usersKey = "blog-post-{$id}-users";
        $users = Cache::get($usersKey, []);
        $now = now();
        $users[$sessionId] = $now;
        $currentUsers = [];

        foreach($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) < 1) {
                $currentUsers[$session] = $lastVisit; 
            }
        }

        Cache::put($usersKey, $currentUsers);
        $counter = count($currentUsers);

        return view('posts.show', [
            'post' => $blogPost,
            'counter' => $counter
        ]);
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
        $post->delete();
        session()->flash('status', 'The blog post was deleted successfully');
        return redirect()->route('posts.index');
    }
}
