<?php

namespace QMILibs\StardustConnectClient\HttpClient\Plugin;

use QMILibs\StardustConnectClient\Event\StardustConnectEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use QMILibs\StardustConnectClient\Event\RequestEvent;

/**
 * Class AuthorizationHeaderPlugin
 * @package QMILibs\StardustConnectClient\HttpClient\Plugin
 */
class AuthorizationHeaderPlugin implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public static function getSubscribedEvents()
    {
        return [
            StardustConnectEvents::BEFORE_REQUEST => 'onBeforeSend',
        ];
    }

    public function onBeforeSend(RequestEvent $event)
    {
        $event->getRequest()->getHeaders()->set('Authorization', 'Bearer ' . $this->token);
    }
}
