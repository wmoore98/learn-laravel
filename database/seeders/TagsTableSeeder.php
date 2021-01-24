<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagNames = collect(['Science', 'Sports', 'Politics', 'Entertainment', 'Economy']);
        $tagNames->each(function ($tagName) {
            Tag::create(['name' => $tagName]);
        });
    }
}
