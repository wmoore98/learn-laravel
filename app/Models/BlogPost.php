<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use App\Traits\Taggable;

class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Taggable;
    
    protected $fillable = ['title', 'content', 'user_id'];

    public function scopeLatest(Builder $query)
    {
        $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopeLatestWithRelations(Builder $query)
    {
        $query->latest()
            ->withCount('comments')
            ->with('user', 'tags');
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope);
        
        parent::boot();
        
        static::deleting(function (BlogPost $blogPost) {
            Cache::forget("blog-post-{$blogPost->id}");
            $blogPost->comments()->delete();
        });

        static::updating(function (BlogPost $blogPost) {
            Cache::forget("blog-post-{$blogPost->id}");
        });
        
        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
