<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPostedMarkdown extends Mailable // implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Comment $comment; // markdown seems to need this to be public when ran as a job

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "{$this->comment->user->name} commented on your blog post: {$this->comment->commentable->title}.";
        return $this
            ->subject($subject)
            ->markdown('emails.posts.commented-markdown');
    }
}
