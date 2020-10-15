<?php

namespace QMILibs\StardustConnectClient\HttpClient\Plugin;

use QMILibs\StardustConnectClient\Event\StardustConnectEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use QMILibs\StardustConnectClient\Event\RequestEvent;

/**
 * Class ContentTypeJsonHeaderPlugin
 * @package QMILibs\StardustConnectClient\HttpClient\Plugin
 */
class ContentTypeJsonHeaderPlugin implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            StardustConnectEvents::BEFORE_REQUEST => 'onBeforeSend'
        ];
    }

    public function onBeforeSend(RequestEvent $event)
    {
        $method = $event->getRequest()->getMethod();

        if (
            $method == 'POST'  ||
            $method == 'PUT'   ||
            $method == 'PATCH' ||
            $method == 'DELETE'
        ) {
            $event->getRequest()->getHeaders()->set('Content-Type', 'application/json');
        }
    }
}
