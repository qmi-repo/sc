<?php

namespace QMILibs\StardustConnectClient\Model;

/**
 * Class User
 * @package QMILibs\StardustConnectClient\Modelù
 */
class MovieGenre extends AbstractModel implements RegistrableModelInterface
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
    private $name;

    /**
     * @var string
     */
    private $tmdbId;

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
        "name",
        "tmdbId",
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
     * @return MovieGenre
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return MovieGenre
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return MovieGenre
     */
    public function setTmdbId($tmdbId)
    {
        $this->tmdbId = $tmdbId;
        return $this;
    }
}
