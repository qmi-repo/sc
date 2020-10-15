<?php

namespace QMILibs\StardustConnectClient\Factory;

use QMILibs\StardustConnectClient\HttpClient\HttpClient;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;
use QMILibs\StardustConnectClient\Model\UserProfile;

/**
 * Class TokenFactory
 * @package QMILibs\StardustConnectClient\Factory
 */
class UserProfileFactory extends AbstractFactory
{

    /**
     * @var CityFactory
     */
    private $cityFactory;

    /**
     * MovieFactory constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);
        $this->cityFactory = new CityFactory($httpClient);
    }

    /**
     * @param  array $data
     *
     * @return UserProfile
     */
    public function create(array $data = [])
    {
        if (!$data) {
            return NULL;
        }

        $userProfile = new UserProfile();

        if (array_key_exists('birthday', $data) && is_string($data['birthday'])) {
            $userProfile->setBirthday(\DateTime::createFromFormat(\DateTime::ISO8601, $data['birthday']));
        }

        if (array_key_exists('lockedAt', $data) && is_string($data['lockedAt'])) {
            $userProfile->setLockedAt(\DateTime::createFromFormat(\DateTime::ISO8601, $data['lockedAt']));
        }

        if (array_key_exists('disabledAt', $data) && is_string($data['disabledAt'])) {
            $userProfile->setDisabledAt(\DateTime::createFromFormat(\DateTime::ISO8601, $data['disabledAt']));
        }

        if (array_key_exists('_embedded', $data) && array_key_exists('city', $data['_embedded']) && is_array($data['_embedded']['city'])) {
            $userProfile->setCity($this->getCityFactory()->create($data['_embedded']['city']));
        }

        /** @var UserProfile $userProfile */
        $userProfile = $this->hydrate($userProfile, $data);
        return $userProfile;
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

    /**
     * @return CityFactory
     */
    public function getCityFactory()
    {
        return $this->cityFactory;
    }
}
