<?php

namespace QMILibs\StardustConnectClient;

trait ApiMethodTrait
{
    /**
     * @return Api\UserApi
     */
    public function getUserApi(Client $client)
    {
        return new Api\UserApi($client);
    }
}
