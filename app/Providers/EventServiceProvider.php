<?php

namespace App\Providers;

use App\Models\Division;
use App\Observers\DivisionObserver;
use App\Models\Worker;
use App\Observers\WorkerObserver;
use App\Models\Document;
use App\Observers\DocumentObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Division::observe(DivisionObserver::class);
        Document::observe(DocumentObserver::class);
        Worker::observe(WorkerObserver::class);
    }
}
