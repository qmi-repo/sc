<?php

namespace QMILibs\StardustConnectClient\Model;

/**
 * Class Token
 * @package QMILibs\StardustConnectClient\Model
 */
class Token extends AbstractModel
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var \DateTime
     */
    private $expires;

    /**
     * Properties that are available in the API
     *
     * These properties are hydrated by the ObjectHydrator, all the other properties are handled by the factory.
     *
     * @var array
     */
    public static $properties = [
        'token',
    ];

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return Token
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param \DateTime $expires
     *
     * @return Token
     */
    public function setExpires(\DateTime $expires)
    {
        $this->expires = $expires;
        return $this;
    }
}
