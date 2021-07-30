<?php

namespace App\Observers;

use App\Models\Subscription;
use App\Services\Search\SubscriptionSearchService;
use Illuminate\Support\Facades\App;

class SubscriptionObserver
{
    /**
     * Handle the Subscription "created" event.
     *
     * @param  Subscription  $subscription
     * @return void
     */
    public function created(Subscription $subscription)
    {
        $esService = App::make(SubscriptionSearchService::class);
        $esService->index($subscription);
    }

    /**
     * Handle the Subscription "updated" event.
     *
     * @param  Subscription  $subscription
     * @return void
     */
    public function updated(Subscription $subscription)
    {
        $esService = App::make(SubscriptionSearchService::class);
        $esService->index($subscription);
    }

    /**
     * Handle the Subscription "deleted" event.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return void
     */
    public function deleted(Subscription $subscription)
    {
        //
    }

    /**
     * Handle the Subscription "restored" event.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return void
     */
    public function restored(Subscription $subscription)
    {
        //
    }

    /**
     * Handle the Subscription "force deleted" event.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return void
     */
    public function forceDeleted(Subscription $subscription)
    {
        //
    }
}
