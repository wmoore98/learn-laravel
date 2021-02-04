@component('mail::message')
# A comment was posted on a blog post you are watching
## [{{ $comment->commentable->title }}]({{ route('posts.show', ['post' => $comment->commentable->id]) }})

Hi {{ $user->name }},

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
