<?php

namespace QMILibs\StardustConnectClient\Repository;

use QMILibs\StardustConnectClient\Api\AbstractApi;
use QMILibs\StardustConnectClient\Client;
use QMILibs\StardustConnectClient\Exception\RuntimeException;
use QMILibs\StardustConnectClient\Factory\AbstractFactory;
use QMILibs\StardustConnectClient\Model\Common\QueryParameter\QueryParameterInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class AbstractRepository
 * @package QMILibs\StardustConnectClient\Repository
 */
abstract class AbstractRepository
{
    protected $client = NULL;

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
     * Return the client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->client->getEventDispatcher();
    }

    /**
     * Process query parameters
     *
     * @param  array $parameters
     *
     * @return array
     */
    protected function parseQueryParameters(array $parameters = [])
    {
        foreach ($parameters as $key => $candidate) {
            if (is_a($candidate, QueryParameterInterface::class)) {
                $interfaces = class_implements($candidate);

                if (array_key_exists(QueryParameterInterface::class, $interfaces)) {
                    unset($parameters[$key]);

                    $parameters[$candidate->getKey()] = $candidate->getValue();
                }
            }
        }

        return $parameters;
    }

    /**
     * Return the API Class
     *
     * @return AbstractApi
     */
    public function getApi(){
        throw new RuntimeException("No API object was defined for repository class ".__CLASS__);
    }

    /**
     * Return the Factory Class
     *
     * @return AbstractFactory
     */
    abstract public function getFactory();
}
