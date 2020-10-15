<?php

namespace QMILibs\StardustConnectClient\Repository;

use QMILibs\StardustConnectClient\Api\UserApi;
use QMILibs\StardustConnectClient\Client;
use QMILibs\StardustConnectClient\Factory\MovieGenreFactory;
use QMILibs\StardustConnectClient\Factory\UserProfileFactory;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;

/**
 * Class UserProfileRepository
 * @package QMILibs\StardustConnectClient\Repository
 */
class MovieGenreRepository extends AbstractRepository
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
     * @return \QMILibs\StardustConnectClient\Model\MovieGenre[]|GenericCollection
     */
    public function getUserFavoriteMovieGenres(array $parameters = [], array $headers = [])
    {
        $data = $this->getUserApi()->getFavoriteMovieGenres($this->parseQueryParameters($parameters), $headers);

        return $this->getFactory()->createCollection($data);
    }

    /**
     * @return MovieGenreFactory
     */
    public function getFactory()
    {
        return new MovieGenreFactory($this->getClient()->getHttpClient());
    }

    /**
     * @return UserApi
     */
    public function getUserApi()
    {
        return $this->getClient()->getUserApi($this->getClient());
    }
}
