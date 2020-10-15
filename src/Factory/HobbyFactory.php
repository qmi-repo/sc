<?php

namespace QMILibs\StardustConnectClient\Factory;

use QMILibs\StardustConnectClient\HttpClient\HttpClient;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;
use QMILibs\StardustConnectClient\Model\UserCellphone;
use QMILibs\StardustConnectClient\Model\Hobby;

/**
 * Class TokenFactory
 * @package QMILibs\StardustConnectClient\Factory
 */
class HobbyFactory extends AbstractFactory
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
     * @return Hobby
     */
    public function create(array $data = [])
    {
        if (!$data) {
            return NULL;
        }

        $hobby = new Hobby();
        /** @var Hobby $hobby */
        $hobby = $this->hydrate($hobby, $data);
        return $hobby;
    }

    /**
     * {@inheritdoc}
     */
    public function createCollection(array $data = [])
    {
        $collection = new GenericCollection();

        if (array_key_exists('_embedded', $data) && array_key_exists('hobbies', $data['_embedded']) && is_array($data['_embedded']['hobbies'])) {
            $data = $data['_embedded']['hobbies'];
        }

        foreach ($data as $item) {
            $collection->add(NULL, $this->create($item));
        }

        return $collection;
    }
}
