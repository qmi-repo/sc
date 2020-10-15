<?php

namespace QMILibs\StardustConnectClient\HttpClient\Plugin;

use QMILibs\StardustConnectClient\Client;
use QMILibs\StardustConnectClient\Event\RequestEvent;
use QMILibs\StardustConnectClient\Event\StardustConnectEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class AcceptJsonHeaderPlugin
 * @package QMILibs\StardustConnectClient\HttpClient\Plugin
 */
class UserAgentHeaderPlugin implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            StardustConnectEvents::BEFORE_REQUEST => 'onBeforeSend',
        ];
    }

    public function onBeforeSend(RequestEvent $event)
    {
        $event->getRequest()->getHeaders()->set(
            'User-Agent',
            sprintf('qmi-libs/stardust-connect-client (v%s)', Client::VERSION)
        );
    }
}
