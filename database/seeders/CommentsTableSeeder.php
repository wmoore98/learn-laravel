<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
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

        if ($posts->count()) {
            $count = (int) $this->command->ask('How many comments would you like?', 150);
            $this->command->info("Making $count comments...");
    
            Comment::factory($count)->make()->each(function($comment) use($posts) {
                $comment->blog_post_id = $posts->random()->id;
                $comment->save();
            });
        } else {
            $this->command->info('No comments created, since there are no posts.');
        }

    }
}
