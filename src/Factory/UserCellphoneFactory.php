<?php

namespace QMILibs\StardustConnectClient\Factory;

use QMILibs\StardustConnectClient\HttpClient\HttpClient;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;
use QMILibs\StardustConnectClient\Model\UserCellphone;

/**
 * Class TokenFactory
 * @package QMILibs\StardustConnectClient\Factory
 */
class UserCellphoneFactory extends AbstractFactory
{
    /**
     * MovieFactory constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);
    }

    /**
     * @param  array $data
     *
     * @return UserCellphone
     */
    public function create(array $data = [])
    {
        if (!$data) {
            return NULL;
        }

        $userCellphone = new UserCellphone();
        /** @var UserCellphone $userCellphone */
        $userCellphone = $this->hydrate($userCellphone, $data);
        return $userCellphone;
    }

    /**
     * {@inheritdoc}
     */
    public function createCollection(array $data = [])
    {
        $collection = new GenericCollection();

        foreach ($data as $item) {
            $collection->add(NULL, $this->create($item));
        }

        return $collection;
    }
}
