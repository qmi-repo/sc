<?php

namespace QMILibs\StardustConnectClient\Factory;

use QMILibs\StardustConnectClient\HttpClient\HttpClient;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;
use QMILibs\StardustConnectClient\Model\UserCellphone;
use QMILibs\StardustConnectClient\Model\Cinema;
use QMILibs\StardustConnectClient\Model\Movie;

/**
 * Class TokenFactory
 * @package QMILibs\StardustConnectClient\Factory
 */
class MovieFactory extends AbstractFactory
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
     * @return Movie
     *
     * @throws \Exception
     */
    public function create(array $data = [])
    {
        if (!$data) {
            return NULL;
        }

        $favoriteMovie = new Movie();

        if (array_key_exists('releaseDate', $data) && is_string($data['releaseDate'])) {
            $favoriteMovie->setReleaseDate(\DateTime::createFromFormat(\DateTime::ISO8601, $data['releaseDate']));
        }

        if (array_key_exists('runtime', $data) && is_string($data['runtime'])) {
            $favoriteMovie->setRuntime(new \DateInterval($data['runtime']));
        }

        /** @var Movie $favoriteMovie */
        $favoriteMovie = $this->hydrate($favoriteMovie, $data);
        return $favoriteMovie;
    }

    /**
     * {@inheritdoc}
     */
    public function createCollection(array $data = [])
    {
        $collection = new GenericCollection();

        if (array_key_exists('_embedded', $data) && array_key_exists('movies', $data['_embedded']) && is_array($data['_embedded']['movies'])) {
            $data = $data['_embedded']['movies'];
        }

        foreach ($data as $item) {
            $collection->add(NULL, $this->create($item));
        }

        return $collection;
    }
}
