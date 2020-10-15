<?php

namespace QMILibs\StardustConnectClient\Factory;

use QMILibs\StardustConnectClient\HttpClient\HttpClient;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;
use QMILibs\StardustConnectClient\Model\Cinema;

/**
 * Class TokenFactory
 * @package QMILibs\StardustConnectClient\Factory
 */
class CinemaFactory extends AbstractFactory
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
     * @return Cinema
     */
    public function create(array $data = [])
    {
        if (!$data) {
            return NULL;
        }

        $favoriteCinema = new Cinema();

        if (array_key_exists('_embedded', $data) && array_key_exists('city', $data['_embedded']) && is_array($data['_embedded']['city'])) {
            $favoriteCinema->setCity($this->getCityFactory()->create($data['_embedded']['city']));
        }

        /** @var Cinema $favoriteCinema */
        $favoriteCinema = $this->hydrate($favoriteCinema, $data);
        return $favoriteCinema;
    }

    /**
     * {@inheritdoc}
     */
    public function createCollection(array $data = [])
    {
        $collection = new GenericCollection();

        if (array_key_exists('_embedded', $data) && array_key_exists('cinemas', $data['_embedded']) && is_array($data['_embedded']['cinemas'])) {
            $data = $data['_embedded']['cinemas'];
        }

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
