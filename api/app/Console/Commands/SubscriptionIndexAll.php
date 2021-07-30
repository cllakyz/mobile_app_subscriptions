<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Services\Search\SubscriptionSearchService;
use Illuminate\Console\Command;

class SubscriptionIndexAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index all subs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(SubscriptionSearchService $subscriptionSearchService)
    {
        $page = 1;
        $limit = 250;
        $count = 0;
        $devices = Subscription::orderBy('id')->take($limit)->get();
        while ($devices->count()) {
            $subscriptionSearchService->bulkIndex($devices);
            $count += $devices->count();
            $page += 1;
            $devices = Subscription::orderBy('id','desc')->skip(($page - 1) * $limit)->take($limit)->get();

            echo "$count \n";
        }

        return 0;
    }
}
