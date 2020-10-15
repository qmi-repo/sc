<?php

namespace QMILibs\StardustConnectClient\Repository;

use QMILibs\StardustConnectClient\Api\UserApi;
use QMILibs\StardustConnectClient\Client;
use QMILibs\StardustConnectClient\Factory\UserProfileFactory;

/**
 * Class UserProfileRepository
 * @package QMILibs\StardustConnectClient\Repository
 */
class UserProfileRepository extends AbstractRepository
{
    /**
     * @param array $parameters
     * @param array $headers
     *
     * @return \QMILibs\StardustConnectClient\Model\UserProfile
     */
    public function getUserProfile(array $parameters = [], array $headers = [])
    {
        $data = $this->getApi()->getProfile($this->parseQueryParameters($parameters), $headers);

        return $this->getFactory()->create($data);
    }

    /**
     * @return UserProfileFactory
     */
    public function getFactory()
    {
        return new UserProfileFactory($this->getClient()->getHttpClient());
    }

    /**
     * @return UserApi
     */
    public function getApi()
    {
        return $this->getClient()->getUserApi($this->getClient());
    }
}
