<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = BlogPost::all();
        $tags = Tag::all();

        if ($posts->count() === 0) {
            return $this->command->info("No blog posts found, skipping assigning tags to blog posts");
        }
        
        if ($tags->count() === 0) {
            return $this->command->info("No tags found, skipping assigning tags to blog posts");
        }

        $minTags = (int) $this->command->ask('Minimum number of tags per post?', 0);
        $maxTags = (int) $this->command->ask('Maximum number of tags per post?', count($tags));

        $minTags = max(0, min($minTags, $tags->count())); // at least 0 and no more than tag count
        $maxTags = min($tags->count(), max($maxTags, $minTags)); // at least min tags and no more than tag count

        $this->command->info("Adding a minimum of {$minTags} and a maximum of {$maxTags} to each post");

        foreach ($posts as $post) {
            $take = random_int($minTags, $maxTags);
            $post->tags()->attach($tags->random($take)->pluck('id'));
        }
    }
}
