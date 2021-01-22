<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
 
    public function testNoBlogPosts()
    {
        $response = $this->get('/posts');
        $response->assertStatus(200);
        $response->assertSeeText('No posts found!');
    }

    public function testOneBlogPostWithNoComments()
    {
        list($post, $data) = $this->createDummyBlogPost();

        $response = $this->get('/posts');
        $response->assertStatus(200);
        $response->assertSeeText($post->title);
        $response->assertSeeText('No comments yet!');
    }

    public function testOneBlogPostWithComments()
    {
        list($post, $data) = $this->createDummyBlogPost();
        Comment::factory(4)->create([
            'blog_post_id' => $post->id
        ]);

        $response = $this->get('/posts');
        $response->assertStatus(200);
        $response->assertSeeText($post->title);
        $response->assertSeeText('4 comments');
    }

    public function testStoreValid() {
        $data = ['title' => 'Test Title', 'content' => 'This is valid test content.'];
        
        $this->actingAs($this->user())
            ->post('/posts', $data)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created successfully');
        $this->assertDatabaseHas('blog_posts', $data);
    }

    public function testStoreInvalidMissingData() {
        $data = ['title' => '', 'content' => ''];

        // Test missing data
        $this->actingAs($this->user())
            ->post('/posts', $data)
            ->assertStatus(302)
            ->assertSessionHas('errors');
            
        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title field is required.');
        $this->assertEquals($messages['content'][0], 'The content field is required.');
    }

    public function testStoreInvalidTooShortData() {
        $data = ['title' => '1234', 'content' => '12345'];

        // Test too short datva
        $this->actingAs($this->user())
            ->post('/posts', $data)
            ->assertStatus(302)
            ->assertSessionHas('errors');
            
        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testStoreInvalidTooLongData() {
        $data = ['title' => str_repeat('1', 101), 'content' => str_repeat('1', 65536)];

        // Test too short data
        $this->actingAs($this->user())
            ->post('/posts', $data)
            ->assertStatus(302)
            ->assertSessionHas('errors');
            
        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title may not be greater than 100 characters.');
        $this->assertEquals($messages['content'][0], 'The content may not be greater than 65535 characters.');
    }

    public function testUpdateValid() {
        $user = $this->user();
        list ($post, $data) = $this->createDummyBlogPost($user->id);
        $old_data = $data;
        $data['title'] = 'Updated Test Title';
        $data['content'] = 'Updated This is valid test content.';

        $this->actingAs($user)
            ->put("/posts/{$post->id}", $data)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was updated successfully');
        $this->assertDatabaseMissing('blog_posts', $old_data);
        $this->assertDatabaseHas('blog_posts', $data);
    }

    public function testDeleteValid()
    {
        $user = $this->user();
        list ($post, $data) = $this->createDummyBlogPost($user->id);

        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');
        
        $this->assertEquals(session('status'), 'The blog post was deleted successfully');
        // $this->assertDatabaseMissing('blog_posts', $data);
        $this->assertSoftDeleted('blog_posts', $data);
    }

    private function createDummyBlogPost($userId = null): array
    {
       $data = [
            'title' => 'Test Title',
            'content' => 'This is valid test content.',
            'user_id' => $userId ?? (string) $this->user()->id,
        ];
    
        $post = BlogPost::factory()->dummyBlogForTesting($data)->create();
        $data['id'] = (string) $post->id;
        $this->assertDatabaseHas('blog_posts', $data);

        return [$post, $data];
    }

}
