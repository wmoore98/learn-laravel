@component('mail::message')
# Someone has created a blog post


Be sure to proofread it.

Title: [***{{ $blogPost->title }}***]({{ route('posts.show', $blogPost) }})
@component('mail::button', ['url' => route('posts.show', $blogPost)])
Read Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
