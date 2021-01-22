<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'content' => $this->faker->paragraphs(5, true),
            'created_at' => $this->faker->dateTimeBetween('-3 months'),
        ];
    }

    public function dummyBlogForTesting($data)
    {
        // if (! isset($data['user_id'])) {
        //     $user = User::factory(1)->create()[0];
        //     $data["user_id"] = $user->id;
        // }

        return $this->state(function (array $attributes) use($data) {
            return $data;
        });
    }
}
