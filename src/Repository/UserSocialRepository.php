<?php

namespace QMILibs\StardustConnectClient\Repository;

use QMILibs\StardustConnectClient\Api\UserApi;
use QMILibs\StardustConnectClient\Client;
use QMILibs\StardustConnectClient\Factory\UserProfileFactory;
use QMILibs\StardustConnectClient\Factory\UserSocialFactory;

/**
 * Class UserProfileRepository
 * @package QMILibs\StardustConnectClient\Repository
 */
class UserSocialRepository extends AbstractRepository
{
    /**
     * @param array $parameters
     * @param array $headers
     *
     * @return \QMILibs\StardustConnectClient\Model\UserSocial
     */
    public function getUserSocial(array $parameters = [], array $headers = [])
    {
        $data = $this->getApi()->getSocial($this->parseQueryParameters($parameters), $headers);

        return $this->getFactory()->create($data);
    }

    /**
     * @return UserSocialFactory
     */
    public function getFactory()
    {
        return new UserSocialFactory($this->getClient()->getHttpClient());
    }

    /**
     * @return UserApi
     */
    public function getApi()
    {
        return $this->getClient()->getUserApi($this->getClient());
    }
}
