<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{
    public function updating(BlogPost $blogPost)
    {
        Cache::forget("blog-post-{$blogPost->id}");
    }

    public function deleting(BlogPost $blogPost)
    {
        Cache::forget("blog-post-{$blogPost->id}");
        $blogPost->comments()->delete();
    }

    public function restoring(BlogPost $blogPost)
    {
        $blogPost->comments()->restore();
    }
}
