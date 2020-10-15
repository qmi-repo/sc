<?php

namespace QMILibs\StardustConnectClient\HttpClient;


use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Monolog\Logger;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LogLevel;
use QMILibs\StardustConnectClient\Common\ParameterBag;
use QMILibs\StardustConnectClient\Event\HydrationSubscriber;
use QMILibs\StardustConnectClient\Event\RequestEvent;
use QMILibs\StardustConnectClient\Event\RequestSubscriber;
use QMILibs\StardustConnectClient\Event\StardustConnectEvents;
use QMILibs\StardustConnectClient\Exception\ApiKeyMissingException;
use QMILibs\StardustConnectClient\Exception\AppIdMissingException;
use QMILibs\StardustConnectClient\HttpClient\Adapter\AdapterInterface;
use QMILibs\StardustConnectClient\HttpClient\Adapter\GuzzleAdapter;
use QMILibs\StardustConnectClient\HttpClient\Plugin\AcceptJsonHeaderPlugin;
use QMILibs\StardustConnectClient\HttpClient\Plugin\ApiKeyPlugin;
use QMILibs\StardustConnectClient\HttpClient\Plugin\AuthorizationHeaderPlugin;
use QMILibs\StardustConnectClient\HttpClient\Plugin\ContentTypeJsonHeaderPlugin;
use QMILibs\StardustConnectClient\HttpClient\Plugin\RequestJsonFormatPlugin;
use QMILibs\StardustConnectClient\HttpClient\Plugin\UserAgentHeaderPlugin;
use QMILibs\StardustConnectClient\StardustApp;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class HttpClient
 * @package QMILibs\StardustConnectClient\HttpClient
 */
class HttpClient
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var Response
     */
    private $lastResponse;

    /**
     * @var Request
     */
    private $lastRequest;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(
        array $options = []
    )
    {
        $this->options = $options;
        $this->eventDispatcher = $this->options['event_dispatcher'];

        $this->setAdapter($this->options['adapter']);
        $this->processOptions();
    }

    /**
     * {@inheritDoc}
     */
    public function get($path, array $parameters = [], array $headers = [])
    {
        return $this->send($path, 'GET', $parameters, $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, $body, array $parameters = [], array $headers = [])
    {
        return $this->send($path, 'POST', $parameters, $headers, $body);
    }

    /**
     * {@inheritDoc}
     */
    public function head($path, array $parameters = [], array $headers = [])
    {
        return $this->send($path, 'HEAD', $parameters, $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, $body = NULL, array $parameters = [], array $headers = [])
    {
        return $this->send($path, 'PUT', $parameters, $headers, $body);
    }

    /**
     * {@inheritDoc}
     */
    public function patch($path, $body = NULL, array $parameters = [], array $headers = [])
    {
        return $this->send($path, 'PATCH', $parameters, $headers, $body);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path, $body = NULL, array $parameters = [], array $headers = [])
    {
        return $this->send($path, 'DELETE', $parameters, $headers, $body);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param  array $options
     *
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @return RequestInterface
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @return ResponseInterface
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Create the request object and send it out to listening events.
     *
     * @param        $path
     * @param        $method
     * @param  array $parameters
     * @param  array $headers
     * @param  null  $body
     *
     * @return string
     */
    private function send($path, $method, array $parameters = [], array $headers = [], $body = NULL)
    {
        $request = $this->createRequest(
            $path,
            $method,
            $parameters,
            $headers,
            $body
        );

        $event = new RequestEvent($request);
        $this->eventDispatcher->dispatch(StardustConnectEvents::REQUEST, $event);

        $this->lastResponse = $event->getResponse();

        if ($this->lastResponse instanceof Response) {
            return (string)$this->lastResponse->getBody();
        }

        return [];
    }

    /**
     * Create the request object
     *
     * @param        $path
     * @param        $method
     * @param  array $parameters
     * @param  array $headers
     * @param        $body
     *
     * @return Request
     */
    private function createRequest($path, $method, $parameters = [], $headers = [], $body)
    {
        $request = new Request();

        $request
            ->setPath($path)
            ->setMethod($method)
            ->setParameters(new ParameterBag((array)$parameters))
            ->setHeaders(new ParameterBag((array)$headers))
            ->setBody($body)
            ->setOptions(new ParameterBag((array)$this->options));

        return $this->lastRequest = $request;
    }

    /**
     * Add a subscriber
     *
     * @param EventSubscriberInterface $subscriber
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        if ($subscriber instanceof HttpClientEventSubscriber) {
            $subscriber->attachHttpClient($this);
        }

        $this->eventDispatcher->addSubscriber($subscriber);
    }

    /**
     * Remove a subscriber
     *
     * @param EventSubscriberInterface $subscriber
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        if ($subscriber instanceof HttpClientEventSubscriber) {
            $subscriber->attachHttpClient($this);
        }

        $this->eventDispatcher->removeSubscriber($subscriber);
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param  AdapterInterface $adapter
     *
     * @return $this
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $adapter->registerSubscribers($this->getEventDispatcher());
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * Register the default plugins
     *
     * @return $this
     */
    public function registerDefaults()
    {
        if (!array_key_exists('stardustApp', $this->options)) {
            throw new AppIdMissingException('A stardustApp was not configured, please configure the `stardustApp` option with an correct ' . StardustApp::class . ' object.');
        }

        $requestSubscriber = new RequestSubscriber();
        $this->addSubscriber($requestSubscriber);

        $hydrationSubscriber = new HydrationSubscriber();
        $this->addSubscriber($hydrationSubscriber);

        $acceptJsonHeaderPlugin = new AcceptJsonHeaderPlugin();
        $this->addSubscriber($acceptJsonHeaderPlugin);

        $contentTypeHeaderPlugin = new ContentTypeJsonHeaderPlugin();
        $this->addSubscriber($contentTypeHeaderPlugin);

        $userAgentHeaderPlugin = new UserAgentHeaderPlugin();
        $this->addSubscriber($userAgentHeaderPlugin);

        $requestJsonFormatPlugin = new RequestJsonFormatPlugin();
        $this->addSubscriber($requestJsonFormatPlugin);

        if (is_string($this->options['access_token'])) {
            $authHeaderPlugin = new AuthorizationHeaderPlugin($this->options['access_token']);
            $this->addSubscriber($authHeaderPlugin);
        }

        return $this;
    }

    public function isDefaultAdapter()
    {
        if (!class_exists('GuzzleHttp\Client')) {
            return false;
        }

        return ($this->getAdapter() instanceof GuzzleAdapter);
    }

    protected function processOptions()
    {

        $cache = $this->options['cache'];

        if ($cache['enabled']) {
            $this->setupCache($cache);
        }

        $log = $this->options['log'];

        if ($log['enabled']) {
            $this->setupLog($log);
        }
    }

    protected function setupCache(array $cache)
    {
        if ($this->isDefaultAdapter()) {
            $this->setDefaultCaching($cache);
        } elseif (NULL !== $subscriber = $cache['subscriber']) {
            $subscriber->setOptions($cache);
            $this->addSubscriber($subscriber);
        }
    }

    protected function setupLog(array $log)
    {
        if ($this->isDefaultAdapter()) {
            $this->setDefaultLogging($log);
        } elseif (NULL !== $subscriber = $log['subscriber']) {
            $subscriber->setOptions($log);
            $this->addSubscriber($subscriber);
        }
    }

    /**
     * Add an subscriber to enable caching.
     *
     * @param  array $parameters
     *
     * @throws \RuntimeException
     * @return $this
     */
    public function setDefaultCaching(array $parameters)
    {
        if ($parameters['enabled']) {
            if (!class_exists('Doctrine\Common\Cache\CacheProvider')) {
                //@codeCoverageIgnoreStart
                throw new \RuntimeException(
                    'Could not find the doctrine cache library,
                    have you added doctrine-cache to your composer.json?'
                );
                //@codeCoverageIgnoreEnd
            }

            $this->adapter->getClient()->getConfig('handler')->push(
                new CacheMiddleware(
                    new PrivateCacheStrategy(
                        new DoctrineCacheStorage(
                            $parameters['handler']
                        )
                    )
                ),
                'stardust-connect-client-cache'
            );
        }

        return $this;
    }

    /**
     * Enable logging
     *
     * @param  array $parameters
     *
     * @throws \RuntimeException
     * @return $this
     */
    public function setDefaultLogging(array $parameters)
    {
        if ($parameters['enabled']) {
            if (!class_exists('\Monolog\Logger')) {
                //@codeCoverageIgnoreStart
                throw new \RuntimeException(
                    'Could not find any logger set and the monolog logger library was not found
                    to provide a default, you have to  set a custom logger on the client or
                    have you forgot adding monolog to your composer.json?'
                );
                //@codeCoverageIgnoreEnd
            }

            $logger = new Logger('stardust-connect-client');
            $logger->pushHandler($parameters['handler']);

            if ($this->getAdapter() instanceof GuzzleAdapter) {
                $middleware = new \Concat\Http\Middleware\Logger($logger);
                $middleware->setRequestLoggingEnabled(true);
                $middleware->setLogLevel(function ($response) {
                    return LogLevel::DEBUG;
                });

                $this->getAdapter()->getClient()->getConfig('handler')->push(
                    $middleware,
                    'stardust-connect-client-log'
                );
            }
        }

        return $this;
    }
}
