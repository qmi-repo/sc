<?php

namespace QMILibs\StardustConnectClient\Api;

class UserApi extends AbstractApi
{
    const REQUEST_PREFIX = parent::REQUEST_PREFIX.'me/';

    /**
     * @param array $parameters
     * @param array $headers
     *
     * @return mixed
     */
    public function getProfile(array $parameters = [], array $headers = [])
    {
        return $this->get(self::REQUEST_PREFIX . 'profile', $parameters, $headers);
    }

    /**
     * @param array $parameters
     * @param array $headers
     *
     * @return mixed
     */
    public function getSocial(array $parameters = [], array $headers = [])
    {
        return $this->get(self::REQUEST_PREFIX . 'social', $parameters, $headers);
    }

    /**
     * @param array $parameters
     * @param array $headers
     *
     * @return mixed
     */
    public function getCellphone(array $parameters = [], array $headers = [])
    {
        return $this->get(self::REQUEST_PREFIX . 'cellphone', $parameters, $headers);
    }

    /**
     * @param array $parameters
     * @param array $headers
     *
     * @return mixed
     */
    public function getFavoritePosts(array $parameters = [], array $headers = [])
    {
        return $this->get(self::REQUEST_PREFIX . 'favorite-post', $parameters, $headers);
    }

    /**
     * @param array $parameters
     * @param array $headers
     *
     * @return mixed
     */
    public function getFavoriteMovies(array $parameters = [], array $headers = [])
    {
        return $this->get(self::REQUEST_PREFIX . 'favorite-movie', $parameters, $headers);
    }

    /**
     * @param array $parameters
     * @param array $headers
     *
     * @return mixed
     */
    public function getFavoriteMovieGenres(array $parameters = [], array $headers = [])
    {
        return $this->get(self::REQUEST_PREFIX . 'favorite-movie-genre', $parameters, $headers);
    }

    /**
     * @param array $parameters
     * @param array $headers
     *
     * @return mixed
     */
    public function getHobbies(array $parameters = [], array $headers = [])
    {
        return $this->get(self::REQUEST_PREFIX . 'hobby', $parameters, $headers);
    }

    /**
     * @param array $parameters
     * @param array $headers
     *
     * @return mixed
     */
    public function getFavoriteCinemas(array $parameters = [], array $headers = [])
    {
        return $this->get(self::REQUEST_PREFIX . 'favorite-cinema', $parameters, $headers);
    }
}
