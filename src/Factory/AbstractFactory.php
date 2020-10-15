<?php

namespace QMILibs\StardustConnectClient\Factory;

use QMILibs\StardustConnectClient\Event\HydrationEvent;
use QMILibs\StardustConnectClient\Event\StardustConnectEvents;
use QMILibs\StardustConnectClient\HttpClient\HttpClient;
use QMILibs\StardustConnectClient\Model\AbstractModel;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;

/**
 * Class AbstractFactory
 * @package QMILibs\StardustConnectClient\Factory
 */
abstract class AbstractFactory
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * Constructor
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Convert an array to an hydrated object
     *
     * @param  array         $data
     * @return AbstractModel
     */
    abstract public function create(array $data = []);

    /**
     * Convert an array with an collection of items to an hydrated object collection
     *
     * @param  array             $data
     * @return GenericCollection
     */
    abstract public function createCollection(array $data = []);

    /**
     * Get the http client
     *
     * @return HttpClient
     */
    protected function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Create a generic collection of data and map it on the class by it's static parameter $properties
     *
     * @param  array             $data
     * @param $class
     * @return GenericCollection
     */
    protected function createGenericCollection($data = [], $class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $collection = new GenericCollection();

        if (null === $data) {
            return $collection;
        }

        foreach ($data as $item) {
            $collection->add(null, $this->hydrate(new $class(), $item));
        }

        return $collection;
    }

    /**
     * Create a generic collection of data and map it on the class by it's static parameter $properties
     *
     * @param  array             $data
     * @param  AbstractModel     $class
     * @param  GenericCollection $collection
     * @return GenericCollection
     */
    protected function createCustomCollection($data = [], $class, $collection)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        if (null === $data) {
            return $collection;
        }

        foreach ($data as $item) {
            $collection->add(null, $this->hydrate(new $class(), $item));
        }

        return $collection;
    }

    /**
     * @param array $data
     *
     * @return AbstractModel
     */
    public function createResult(array $data = [])
    {
        return $this->hydrate(new Result(), $data);
    }

    /**
     * Hydrate the object with data
     *
     * @param  AbstractModel $subject
     * @param  array         $data
     * @return AbstractModel
     */
    protected function hydrate(AbstractModel $subject, $data = [])
    {
        $httpClient = $this->getHttpClient();

        $event = new HydrationEvent($subject, $data);
        $event->setLastRequest($httpClient->getLastRequest());
        $event->setLastResponse($httpClient->getLastResponse());

        $this->getHttpClient()->getEventDispatcher()->dispatch(StardustConnectEvents::HYDRATE, $event);

        return $event->getSubject();
    }
}
