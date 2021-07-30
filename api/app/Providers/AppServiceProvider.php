<?php

namespace App\Providers;

use App\Models\Subscription;
use App\Observers\SubscriptionObserver;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $hosts = [[
            'host' => config('elasticsearch.host'),
            'port' => config('elasticsearch.port'),
            'scheme' => config('elasticsearch.scheme')
        ]];

        $client = ClientBuilder::create()->setHosts($hosts);

        $username = config('elasticsearch.username');
        $password = config('elasticsearch.password');
        if ($username && $password) {
            $client = $client->setBasicAuthentication($username, $password);
        }

        $client = $client->build();
        $this->app->singleton(Client::class, function () use ($client) {
            return $client;
        });

        Subscription::observe(SubscriptionObserver::class);
    }
}
