<?php

namespace App\Observers;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    public function creating(Comment $comment)
    {
        self::clearRelatedCache($comment);
    }

    public function updating(Comment $comment)
    {
        self::clearRelatedCache($comment);
    }

    public function deleting(Comment $comment)
    {
        self::clearRelatedCache($comment);
    }

    private static function clearRelatedCache(Comment $comment)
    {
        if ($comment->commentable_type === BlogPost::class) {
            /* performance issues when running db:seed
            // Cache::forget("blog-post-{$comment->commentable_id}");
            // Cache::forget("mostCommented");
            */
        }
    }
}
