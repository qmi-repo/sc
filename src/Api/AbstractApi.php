<?php

namespace QMILibs\StardustConnectClient\Api;

use QMILibs\StardustConnectClient\Client;

/**
 * Class AbstractApi
 * @package QMILibs\StardustConnectClient\Api
 */
abstract class AbstractApi
{
    const REQUEST_PREFIX = 'api/';

    /**
     * The client
     *
     * @var Client
     */
    protected $client;

    /**
     * Constructor
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send a GET request
     *
     * @param  string $path
     * @param  array  $parameters
     * @param  array  $headers
     * @return mixed
     */
    public function get($path, array $parameters = [], $headers = [])
    {
        $response = $this->getClient()->getHttpClient()->get($path, $parameters, $headers);

        return $this->decodeResponse($response);
    }

    /**
     * Retrieve the client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Decode the response
     *
     * @param $response
     * @return mixed
     */
    private function decodeResponse($response)
    {
        return is_string($response) ? json_decode($response, true) : $response;
    }
}
