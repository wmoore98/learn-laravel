<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = ['content', 'user_id'];

    public static function boot()
    {
        parent::boot();
        
        static::deleting(function (Comment $comment) {
            // self::clearRelatedCache($comment);
        });

        static::updating(function (Comment $comment) {
            // self::clearRelatedCache($comment);
        });

        static::creating(function (Comment $comment) {
            self::clearRelatedCache($comment);
        });
    }

    private static function clearRelatedCache(Comment $comment)
    {
        if ($comment->commentable_type === BlogPost::class) {
            Cache::forget("blog-post-{$comment->commentable_id}");
            Cache::forget("mostCommented");
        }
    }

    public function scopeLatest(Builder $query)
    {
        $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
