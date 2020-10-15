<?php

namespace QMILibs\StardustConnectClient\Factory;

use QMILibs\StardustConnectClient\HttpClient\HttpClient;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;
use QMILibs\StardustConnectClient\Model\UserCellphone;
use QMILibs\StardustConnectClient\Model\Movie;
use QMILibs\StardustConnectClient\Model\MovieGenre;

/**
 * Class TokenFactory
 * @package QMILibs\StardustConnectClient\Factory
 */
class MovieGenreFactory extends AbstractFactory
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
     * @return MovieGenre
     */
    public function create(array $data = [])
    {
        if (!$data) {
            return NULL;
        }

        $favoriteMovieGenre = new MovieGenre();
        /** @var MovieGenre $favoriteMovieGenre */
        $favoriteMovieGenre = $this->hydrate($favoriteMovieGenre, $data);
        return $favoriteMovieGenre;
    }

    /**
     * {@inheritdoc}
     */
    public function createCollection(array $data = [])
    {
        $collection = new GenericCollection();

        if (array_key_exists('_embedded', $data) && array_key_exists('movieGenres', $data['_embedded']) && is_array($data['_embedded']['movieGenres'])) {
            $data = $data['_embedded']['movieGenres'];
        }

        foreach ($data as $item) {
            $collection->add(NULL, $this->create($item));
        }

        return $collection;
    }
}
