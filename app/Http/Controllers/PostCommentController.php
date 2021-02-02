<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Mail\CommentPostedMarkdown;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);

        $when = now()->addMinutes(1);

        Mail::to($post->user)
            // ->send(new CommentPostedMarkdown($comment));
            // ->queue(new CommentPostedMarkdown($comment));
            ->later($when, new CommentPostedMarkdown($comment));
            
        return redirect()->back()->withStatus('The comment was created successfully');
    }
}
