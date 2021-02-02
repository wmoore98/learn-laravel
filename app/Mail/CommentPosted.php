<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;

    protected Comment $comment;

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
            // First example - full path
            // ->attach(
            //     storage_path('app/public') . "/" . $this->comment->user->image->path, [
            //         'as' => 'profile_picture.jpg',
            //         'mime' => 'image/jpeg'
            //     ]
            // )
            // ->attachFromStorage($this->comment->user->image->path, 'profile_picture.jpg')
            ->subject($subject)
            ->view('emails.posts.commented');
    }
}
