<?php

namespace App\Listeners;

use App\Events\BlogPostPosted;
use App\Jobs\ThrottledMail;
use App\Mail\BlogPostAdded;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminWhenBlogPostCreated
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BlogPostPosted $event)
    {
        // $user = User::where('is_admin', '=', 1)->first();

        User::thatIsAnAdmin()->get()
            ->map(function(User $user) use ($event) {
                ThrottledMail::dispatch(
                    new BlogPostAdded($event->blogPost),
                    $user
                )->onQueue('high');
            });
    }
}
