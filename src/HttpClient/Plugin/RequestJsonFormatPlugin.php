<?php

namespace QMILibs\StardustConnectClient\HttpClient\Plugin;

use QMILibs\StardustConnectClient\Event\StardustConnectEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use QMILibs\StardustConnectClient\Event\RequestEvent;

/**
 * Class RequestJsonFormatPlugin
 * @package QMILibs\StardustConnectClient\HttpClient\Plugin
 */
class RequestJsonFormatPlugin implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            StardustConnectEvents::BEFORE_REQUEST => 'onBeforeSend'
        ];
    }

    public function onBeforeSend(RequestEvent $event)
    {
        $event->getRequest()->getParameters()->set('format', 'json');
    }
}
