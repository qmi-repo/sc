<?php

namespace QMILibs\StardustConnectClient\Factory;

use QMILibs\StardustConnectClient\HttpClient\HttpClient;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;
use QMILibs\StardustConnectClient\Model\Token;

/**
 * Class TokenFactory
 * @package QMILibs\StardustConnectClient\Factory
 */
class TokenFactory extends AbstractFactory
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
     * @return Token
     */
    public function create(array $data = [])
    {
        if (!$data) {
            return NULL;
        }

        $token = new Token();

        if (array_key_exists('expires', $data) && is_string($data['expires'])) {
            $token->setExpires(\DateTime::createFromFormat(\DateTime::ISO8601, $data['expires']));
        }

        /** @var Token $token */
        $token = $this->hydrate($token, $data);
        return $token;
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
