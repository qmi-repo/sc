<?php

namespace QMILibs\StardustConnectClient\Model;

/**
 * Class User
 * @package QMILibs\StardustConnectClient\Modelù
 */
class UserSocial extends AbstractModel implements RegistrableModelInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $facebookId;

    /**
     * @var string
     */
    private $googlePlusId;

    /**
     * Properties that are available in the API
     *
     * These properties are hydrated by the ObjectHydrator, all the other properties are handled by the factory.
     *
     * @var array
     */
    public static $properties = [
        "id",
        "facebookId",
        "googlePlusId",
    ];

    /**
     * @return int
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
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param string $facebookId
     *
     * @return UserSocial
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        return $this;
    }

    /**
     * @return string
     */
    public function getGooglePlusId()
    {
        return $this->googlePlusId;
    }

    /**
     * @param string $googlePlusId
     *
     * @return UserSocial
     */
    public function setGooglePlusId($googlePlusId)
    {
        $this->googlePlusId = $googlePlusId;
        return $this;
    }
}
