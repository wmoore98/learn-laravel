<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = BlogPost::all();
        $users = User::all();

        if ($posts->count() && $users->count()) {
            $count = (int) $this->command->ask('How many comments would you like?', 150);
            $this->command->info("Making $count comments...");
    
            Comment::factory($count)->make()->each(function($comment) use($posts, $users) {
                $comment->commentable_id = $posts->random()->id;
                $comment->commentable_type = BlogPost::class;
                $comment->user_id = $users->random()->id;
                $comment->save();
            });
    
            Comment::factory($count)->make()->each(function($comment) use($users) {
                $comment->commentable_id = $users->random()->id;
                $comment->commentable_type = User::class;
                $comment->user_id = $users->random()->id;
                $comment->save();
            });
        } else {
            $this->command->info('No comments created, since there are no posts and/or users.');
        }

    }
}
