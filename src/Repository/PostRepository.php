<?php

namespace QMILibs\StardustConnectClient\Repository;

use QMILibs\StardustConnectClient\Api\UserApi;
use QMILibs\StardustConnectClient\Client;
use QMILibs\StardustConnectClient\Factory\PostFactory;
use QMILibs\StardustConnectClient\Factory\UserProfileFactory;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;

/**
 * Class UserProfileRepository
 * @package QMILibs\StardustConnectClient\Repository
 */
class PostRepository extends AbstractRepository
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
     * @return \QMILibs\StardustConnectClient\Model\Post[]|GenericCollection
     */
    public function getUserFavoritePosts(array $parameters = [], array $headers = [])
    {
        $data = $this->getUserApi()->getFavoritePosts($this->parseQueryParameters($parameters), $headers);

        return $this->getFactory()->createCollection($data);
    }

    /**
     * @return PostFactory
     */
    public function getFactory()
    {
        return new PostFactory($this->getClient()->getHttpClient());
    }

    /**
     * @return UserApi
     */
    public function getUserApi()
    {
        return $this->getClient()->getUserApi($this->getClient());
    }
}
