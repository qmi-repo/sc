<?php
namespace QMILibs\StardustConnectClient\HttpClient;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class HttpClientEventSubscriber
 * @package QMILibs\StardustConnectClient\HttpClient
 */
abstract class HttpClientEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @param HttpClient $httpClient
     */
    public function attachHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }
}
