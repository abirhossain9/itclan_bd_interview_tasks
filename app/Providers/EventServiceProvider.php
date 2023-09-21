<?php

namespace App\Providers;

use App\Events\TournamentConditionMet;
use App\Listeners\RunTournamentCommand;
use App\Models\Idea;
use App\Observers\IdeaObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TournamentConditionMet::class => [
            RunTournamentCommand::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Idea::observe(IdeaObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
