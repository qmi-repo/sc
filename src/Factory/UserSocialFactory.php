<?php

namespace QMILibs\StardustConnectClient\Factory;

use QMILibs\StardustConnectClient\HttpClient\HttpClient;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;
use QMILibs\StardustConnectClient\Model\UserCellphone;
use QMILibs\StardustConnectClient\Model\UserSocial;

/**
 * Class TokenFactory
 * @package QMILibs\StardustConnectClient\Factory
 */
class UserSocialFactory extends AbstractFactory
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
     * @return UserSocial
     */
    public function create(array $data = [])
    {
        if (!$data) {
            return NULL;
        }

        $social = new UserSocial();
        /** @var UserSocial $social */
        $social = $this->hydrate($social, $data);
        return $social;
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
