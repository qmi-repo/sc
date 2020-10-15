<?php

namespace QMILibs\StardustConnectClient\Repository;

use QMILibs\StardustConnectClient\Api\UserApi;
use QMILibs\StardustConnectClient\Client;
use QMILibs\StardustConnectClient\Factory\UserCellphoneFactory;
use QMILibs\StardustConnectClient\Factory\UserProfileFactory;

/**
 * Class UserProfileRepository
 * @package QMILibs\StardustConnectClient\Repository
 */
class UserCellphoneRepository extends AbstractRepository
{
    /**
     * @param array $parameters
     * @param array $headers
     *
     * @return \QMILibs\StardustConnectClient\Model\UserCellphone
     */
    public function getUserCellphone(array $parameters = [], array $headers = [])
    {
        $data = $this->getApi()->getCellphone($this->parseQueryParameters($parameters), $headers);

        return $this->getFactory()->create($data);
    }

    /**
     * @return UserCellphoneFactory
     */
    public function getFactory()
    {
        return new UserCellphoneFactory($this->getClient()->getHttpClient());
    }

    /**
     * @return UserApi
     */
    public function getApi()
    {
        return $this->getClient()->getUserApi($this->getClient());
    }
}
