<?php

namespace App\Mail;

use App\Models\BlogPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BlogPostAdded extends Mailable
{
    use Queueable, SerializesModels;
    
    private BlogPost $blogPost;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BlogPost $blogPost)
    {
        $this->blogPost = $blogPost;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.posts.blog-post-added', [
                'blogPost' => $this->blogPost,
                'myVar' => 'hello'
            ]);
    }
}
