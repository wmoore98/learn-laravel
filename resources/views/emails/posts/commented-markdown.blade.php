@component('mail::message')
# A comment was posted on your blog post

Hi {{ $comment->commentable->user->name }},

Someone has commented on your blog post:
[{{ $comment->commentable->title }}]({{ route('posts.show', ['post' => $comment->commentable->id]) }})

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable->id])])
View blog post
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user->id])])
Visit {{ $comment->user->name }}'s profile
@endcomponent

@component('mail::panel')
{{ $comment->content }}    
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
