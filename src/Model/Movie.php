<?php

namespace QMILibs\StardustConnectClient\Model;

/**
 * Class User
 * @package QMILibs\StardustConnectClient\Modelù
 */
class Movie extends AbstractModel implements RegistrableModelInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $adult;

    /**
     * @var string
     */
    private $imdbId;

    /**
     * @var string
     */
    private $tmdbId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     */
    private $releaseDate;

    /**
     * @var \DateInterval
     */
    private $runtime;

    /**
     * Properties that are available in the API
     *
     * These properties are hydrated by the ObjectHydrator, all the other properties are handled by the factory.
     *
     * @var array
     */
    public static $properties = [
        "id",
        "slug",
        "adult",
        "imdbId",
        "tmdbId",
        "title",
    ];

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return Movie
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdult()
    {
        return $this->adult;
    }

    /**
     * @param string $adult
     *
     * @return Movie
     */
    public function setAdult($adult)
    {
        $this->adult = $adult;
        return $this;
    }

    /**
     * @return string
     */
    public function getImdbId()
    {
        return $this->imdbId;
    }

    /**
     * @param string $imdbId
     *
     * @return Movie
     */
    public function setImdbId($imdbId)
    {
        $this->imdbId = $imdbId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTmdbId()
    {
        return $this->tmdbId;
    }

    /**
     * @param string $tmdbId
     *
     * @return Movie
     */
    public function setTmdbId($tmdbId)
    {
        $this->tmdbId = $tmdbId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param \DateTime $releaseDate
     *
     * @return Movie
     */
    public function setReleaseDate(\DateTime $releaseDate)
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * @return \DateInterval
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * @param \DateInterval $runtime
     *
     * @return Movie
     */
    public function setRuntime(\DateInterval $runtime)
    {
        $this->runtime = $runtime;
        return $this;
    }
}
