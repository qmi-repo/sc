<?php

namespace QMILibs\StardustConnectClient\Factory;

use QMILibs\StardustConnectClient\HttpClient\HttpClient;
use QMILibs\StardustConnectClient\Model\City;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;

/**
 * Class CityFactory
 * @package QMILibs\StardustConnectClient\Factory
 */
class CityFactory extends AbstractFactory
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
     * @return City
     */
    public function create(array $data = [])
    {
        if (!$data) {
            return NULL;
        }

        $city = new City();

        /** @var City $city */
        $city = $this->hydrate($city, $data);
        return $city;
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
