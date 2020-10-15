<?php

namespace QMILibs\StardustConnectClient\Event;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use QMILibs\StardustConnectClient\Exception\RuntimeException;
use QMILibs\StardustConnectClient\HttpClient\HttpClientEventSubscriber;
use QMILibs\StardustConnectClient\HttpClient\Response;

/**
 * Class RequestSubscriber
 * @package QMILibs\StardustConnectClient\Event
 */
class RequestSubscriber extends HttpClientEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            StardustConnectEvents::REQUEST => 'send',
        ];
    }

    /**
     * @param RequestEvent             $event
     * @param string                   $eventName
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return string|Response
     * @throws \Exception
     */
    public function send(RequestEvent $event, $eventName, EventDispatcherInterface $eventDispatcher)
    {
        // Preparation of request parameters / Possibility to use for logging and caching etc.
        $eventDispatcher->dispatch(StardustConnectEvents::BEFORE_REQUEST, $event);

        if ($event->isPropagationStopped() && $event->hasResponse()) {
            return $event->getResponse();
        }

        $response = $this->sendRequest($event);
        $event->setResponse($response);

        // Possibility to cache the request
        $eventDispatcher->dispatch(StardustConnectEvents::AFTER_REQUEST, $event);

        return $response;
    }

    /**
     * Call upon the adapter to create an response object
     *
     * @param  RequestEvent $event
     * @throws \Exception
     * @return Response
     */
    public function sendRequest(RequestEvent $event)
    {
        switch ($event->getMethod()) {
            case 'GET':
                $response = $this->getHttpClient()->getAdapter()->get($event->getRequest());
                break;
            case 'HEAD':
                $response = $this->getHttpClient()->getAdapter()->head($event->getRequest());
                break;
            case 'POST':
                $response = $this->getHttpClient()->getAdapter()->post($event->getRequest());
                break;
            case 'PUT':
                $response = $this->getHttpClient()->getAdapter()->put($event->getRequest());
                break;
            case 'PATCH':
                $response = $this->getHttpClient()->getAdapter()->patch($event->getRequest());
                break;
            case 'DELETE':
                $response = $this->getHttpClient()->getAdapter()->delete($event->getRequest());
                break;
            default:
                throw new RuntimeException(sprintf('Unknown request method "%s".', $event->getMethod()));
        }

        return $response;
    }
}
