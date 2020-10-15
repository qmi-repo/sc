<?php

namespace QMILibs\StardustConnectClient\Event;

use QMILibs\StardustConnectClient\Model\AbstractModel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use QMILibs\StardustConnectClient\Common\ObjectHydrator;
use QMILibs\StardustConnectClient\HttpClient\HttpClientEventSubscriber;

/**
 * Class RequestSubscriber
 * @package QMILibs\StardustConnectClient\Event
 */
class HydrationSubscriber extends HttpClientEventSubscriber
{
    /**
     * Get subscribed events
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            StardustConnectEvents::HYDRATE => 'hydrate',
        ];
    }

    /**
     * Hydrate the subject with data
     *
     * @param HydrationEvent           $event
     * @param string                   $eventName
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return AbstractModel
     */
    public function hydrate(HydrationEvent $event, $eventName, $eventDispatcher)
    {
        // Possibility to load serialized cache
        $eventDispatcher->dispatch(StardustConnectEvents::BEFORE_HYDRATION, $event);

        if ($event->isPropagationStopped()) {
            return $event->getSubject();
        }

        $subject = $this->hydrateSubject($event);
        $event->setSubject($subject);

        // Possibility to cache the data
        $eventDispatcher->dispatch(StardustConnectEvents::AFTER_HYDRATION, $event);

        return $event->getSubject();
    }

    /**
     * Hydrate the subject
     *
     * @param  HydrationEvent            $event
     * @return AbstractModel
     */
    public function hydrateSubject(HydrationEvent $event)
    {
        $objectHydrator = new ObjectHydrator();

        return $objectHydrator->hydrate($event->getSubject(), $event->getData());
    }
}
