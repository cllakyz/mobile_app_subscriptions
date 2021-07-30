<?php

namespace App\Services\Search;

use Elasticsearch\Client;

class ElasticsearchService
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search($index, $body)
    {
        if (!$this->isEnabled()) {
            return null;
        }

        try {
            $params = [
                'index' => $index,
                'body'  => $body
            ];

            return $this->client->search($params);

        } catch (\Exception $e) {
            return null;
        }
    }

    public function createIndex(string $index, array $mappings, array $settings)
    {
        if (!$this->isEnabled()) {
            return null;
        }

        try {
            $params = [
                'index' => $index,
                'body' => [
                    'settings' => $settings,
                    'mappings' => $mappings
                ]
            ];

            // Create the index with mappings and settings now
            return $this->client->indices()->create($params);

        } catch (\Exception $e) {
            return null;
        }
    }

    public function indexDocument(string $index, array $body)
    {
        if (!$this->isEnabled()) {
            return null;
        }

        try {
            $params = [
                'index' => $index,
                'id' => $body['id'],
                'body' => $body
            ];

            // Create the index with mappings and settings now
            return $this->client->index($params);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function bulkIndex(string $index, array $body)
    {
        if (!$this->isEnabled()) {
            return null;
        }

        try {
            $params = ['body' => []];

            for ($i = 0; $i < count($body); $i++) {
                $params['body'][] = [
                    'index' => [
                        '_index' => $index,
                        '_id'    => $body[$i]['id']
                    ]
                ];

                $params['body'][] = $body[$i];

                // Every 1000 documents stop and send the bulk request
                if ($i % 1000 == 0) {
                    $responses = $this->client->bulk($params);

                    // erase the old bulk request
                    $params = ['body' => []];

                    // unset the bulk response when you are done to save memory
                    unset($responses);
                }
            }

            // Send the last batch if it exists
            if (!empty($params['body'])) {
                $responses = $this->client->bulk($params);
            }

            return $responses;
        } catch (\Exception $e) {

            return null;
        }
    }

    private function isEnabled()
    {
        return config('elasticsearch.enabled', false);
    }
}
