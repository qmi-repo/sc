<?php

namespace QMILibs\StardustConnectClient\HttpClient\Plugin;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use QMILibs\StardustConnectClient\Event\RequestEvent;
use QMILibs\StardustConnectClient\Event\StardustConnectEvents;

/**
 * Class AcceptJsonHeaderPlugin
 * @package QMILibs\StardustConnectClient\HttpClient\Plugin
 */
class AcceptJsonHeaderPlugin implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            StardustConnectEvents::BEFORE_REQUEST => 'onBeforeSend'
        ];
    }

    public function onBeforeSend(RequestEvent $event)
    {
        $event->getRequest()->getHeaders()->set('Accept', 'application/json');
    }
}
