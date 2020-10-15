<?php

namespace QMILibs\StardustConnectClient\Repository;

use QMILibs\StardustConnectClient\Api\UserApi;
use QMILibs\StardustConnectClient\Client;
use QMILibs\StardustConnectClient\Factory\MovieFactory;
use QMILibs\StardustConnectClient\Factory\UserProfileFactory;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;

/**
 * Class UserProfileRepository
 * @package QMILibs\StardustConnectClient\Repository
 */
class MovieRepository extends AbstractRepository
{
    /**
     * UserProfileRepository constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * @param array $parameters
     * @param array $headers
     *
     * @return \QMILibs\StardustConnectClient\Model\Movie[]|GenericCollection
     */
    public function getUserFavoriteMovies(array $parameters = [], array $headers = [])
    {
        $data = $this->getUserApi()->getFavoriteMovies($this->parseQueryParameters($parameters), $headers);

        return $this->getFactory()->createCollection($data);
    }

    /**
     * @return MovieFactory
     */
    public function getFactory()
    {
        return new MovieFactory($this->getClient()->getHttpClient());
    }

    /**
     * @return UserApi
     */
    public function getUserApi()
    {
        return $this->getClient()->getUserApi($this->getClient());
    }
}
