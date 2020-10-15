<?php

namespace QMILibs\StardustConnectClient;

use Doctrine\Common\Cache\FilesystemCache;
use Monolog\Handler\StreamHandler;
use Psr\Log\LogLevel;
use QMILibs\StardustConnectClient\Factory\TokenFactory;
use QMILibs\StardustConnectClient\Model\Token;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\OptionsResolver\OptionsResolver;
use QMILibs\StardustConnectClient\HttpClient\Adapter\AdapterInterface;
use QMILibs\StardustConnectClient\HttpClient\Adapter\GuzzleAdapter;
use QMILibs\StardustConnectClient\HttpClient\HttpClient;

/**
 * Class Client
 * @package QMILibs\StardustConnectClient
 */
class Client
{
    use ApiMethodTrait;

    /** API Client version */
    const VERSION = '0.1';

    /** Base API URI */
    const BASE_URI = 'www.stardust.it';

    /** Secure schema */
    const SCHEME_SECURE = 'https';

    /** Insecure schema */
    const SCHEME_INSECURE = 'http';

    /**
     * Stores the HTTP Client
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Store the options
     *
     * @var array
     */
    private $options = [];

    /**
     * Construct our client
     *
     * @param StardustApp $stardustApp
     * @param array       $options
     *
     * @throws \Exception
     */
    public function __construct(StardustApp $stardustApp, $options = [])
    {
        $this->configureOptions(array_replace(['stardustApp' => $stardustApp], (array)$options));
        $this->constructHttpClient();
    }

    /**
     * @param $redirectUrl
     *
     * @return string
     */
    public function getLoginUrl($redirectUrl)
    {
        return $this->buildUri($this->getStardustConnectUrl(), [
            'query' => [
                'client_id'    => $this->getStardustApp()->getId(),
                'redirect_uri' => $redirectUrl,
            ],
        ]);
    }

    /**
     * @param HttpClient $httpClient
     */
    public function setHttpClient(HttpClient $httpClient)
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

    /**
     * @return StardustApp
     */
    public function getStardustApp()
    {
        return $this->options['stardustApp'];
    }

    /**
     * @return string
     */
    public function getStardustConnectUrl()
    {
        return $this->options['stardustConnectUrl'];
    }

    /**
     * Get the adapter
     *
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->options['adapter'];
    }

    /**
     * Get the event dispatcher
     *
     * @return EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->options['event_dispatcher'];
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public function getOption($key)
    {
        return array_key_exists($key, $this->options) ? $this->options[$key] : NULL;
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     */
    public function setOptions(array $options = [])
    {
        $this->options = $this->configureOptions($options);
    }

    /**
     * Construct the http client
     *
     * In case you are implementing your own adapter, the base url will be passed on through the options bag
     * at every call in the respective get / post methods etc. of the adapter.
     *
     * @return void
     */
    protected function constructHttpClient()
    {
        $hasHttpClient = (NULL !== $this->httpClient);

        $this->httpClient = new HttpClient($this->getOptions());

        if (!$hasHttpClient) {
            $this->httpClient->registerDefaults();
        }
    }

    /**
     * Reconstruct the HTTP Client
     */
    protected function reconstructHttpClient()
    {
        if (NULL !== $this->getHttpClient()) {
            $this->constructHttpClient();
        }
    }

    /**
     * Configure options
     *
     * @param  array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function configureOptions(array $options)
    {
        $resolver = new OptionsResolver();

        $resolver->setDefaults([
            'access_token'       => NULL,
            'adapter'            => NULL,
            'host'               => self::BASE_URI,
            'base_url'           => NULL,
            'stardustApp'        => NULL,
            'secure'             => true,
            'event_dispatcher'   => array_key_exists('event_dispatcher', $this->options) ? $this->options['event_dispatcher'] : new EventDispatcher(),
            'cache'              => [],
            'log'                => [],
            'stardustConnectUrl' => 'https://www.stardust.it/stardust-connect',
            'adapter_config'     => [],
        ]);

        $resolver->setRequired([
            'adapter',
            'host',
            'stardustApp',
            'secure',
            'event_dispatcher',
            'cache',
            'log',
            'stardustConnectUrl',
        ]);

        $resolver->setAllowedTypes('access_token', ['string', 'null']);
        $resolver->setAllowedTypes('adapter', ['object', 'null']);
        $resolver->setAllowedTypes('host', ['string']);
        $resolver->setAllowedTypes('secure', ['bool']);
        $resolver->setAllowedTypes('stardustApp', ['object']);
        $resolver->setAllowedTypes('stardustConnectUrl', ['string']);
        $resolver->setAllowedTypes('event_dispatcher', ['object']);
        $resolver->setAllowedTypes('adapter_config', ['array']);

        $this->options = $resolver->resolve($options);

        $this->postResolve($options);

        return $this->options;
    }

    /**
     * Configure caching
     *
     * @param  array $options
     *
     * @return array
     */
    protected function configureCacheOptions(array $options = [])
    {
        $resolver = new OptionsResolver();

        $resolver->setDefaults([
            'enabled'    => true,
            'handler'    => NULL,
            'subscriber' => NULL,
            'path'       => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'stardust-connect-client',
        ]);

        $resolver->setRequired([
            'enabled',
            'handler',
        ]);

        $resolver->setAllowedTypes('enabled', ['bool']);
        $resolver->setAllowedTypes('handler', ['object', 'null']);
        $resolver->setAllowedTypes('subscriber', ['object', 'null']);
        $resolver->setAllowedTypes('path', ['string', 'null']);

        $options = $resolver->resolve(array_key_exists('cache', $options) ? $options['cache'] : []);

        if ($options['enabled'] && !$options['handler']) {
            $options['handler'] = new FilesystemCache($options['path']);
        }

        return $options;
    }

    /**
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function configureLogOptions(array $options = [])
    {
        $resolver = new OptionsResolver();

        $resolver->setDefaults([
            'enabled'    => false,
            'level'      => LogLevel::DEBUG,
            'handler'    => NULL,
            'subscriber' => NULL,
            'path'       => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'stardust-connect-client.log',
        ]);

        $resolver->setRequired([
            'enabled',
            'level',
            'handler',
        ]);

        $resolver->setAllowedTypes('enabled', ['bool']);
        $resolver->setAllowedTypes('level', ['string']);
        $resolver->setAllowedTypes('handler', ['object', 'null']);
        $resolver->setAllowedTypes('path', ['string', 'null']);
        $resolver->setAllowedTypes('subscriber', ['object', 'null']);

        $options = $resolver->resolve(array_key_exists('log', $options) ? $options['log'] : []);

        if ($options['enabled'] && !$options['handler']) {
            $options['handler'] = new StreamHandler(
                $options['path'],
                $options['level']
            );
        }

        return $options;
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     */
    protected function postResolve(array $options = [])
    {
        $this->options['base_url'] = sprintf(
            '%s://%s',
            $this->options['secure'] ? self::SCHEME_SECURE : self::SCHEME_INSECURE,
            $this->options['host']
        );

        if (!$this->options['adapter']) {
            $this->options['adapter'] = new GuzzleAdapter(
                new \GuzzleHttp\Client($this->options['adapter_config'])
            );
        }

        $this->options['cache'] = $this->configureCacheOptions($options);
        $this->options['log'] = $this->configureLogOptions($options);
    }

    /**
     * @param $redirectUrl
     * @param $code
     *
     * @return Token
     */
    public function getAccessToken($redirectUrl, $code)
    {
        $response = $this->getHttpClient()->post("stardust-connect/auth/$code", NULL, [
            'redirect_uri'  => $redirectUrl,
            'code'          => $code,
            'client_id'     => $this->getStardustApp()->getId(),
            'client_secret' => $this->getStardustApp()->getSecret(),
        ], ['format' => 'json']);
        $response = is_string($response) ? json_decode($response, true) : $response;
        $tokenFactory = new TokenFactory($this->getHttpClient());
        $token = $tokenFactory->create($response);
        return $token;
    }

    /**
     * Build the absolute URI based on supplied URI and parameters.
     *
     * @param $uri
     * An absolute URI.
     * @param $params
     * Parameters to be append as GET.
     *
     * @return
     * An absolute URI with supplied parameters.
     *
     * @ingroup oauth2_section_4
     */
    public function buildUri($uri, $params)
    {
        $parse_url = parse_url($uri);

        // Add our params to the parsed uri
        foreach ($params as $k => $v) {
            if (isset($parse_url[$k])) {
                $parse_url[$k] .= "&" . http_build_query($v);
            } else {
                $parse_url[$k] = http_build_query($v);
            }
        }

        // Put humpty dumpty back together
        return
            ((isset($parse_url["scheme"])) ? $parse_url["scheme"] . "://" : "")
            . ((isset($parse_url["user"])) ? $parse_url["user"]
                . ((isset($parse_url["pass"])) ? ":" . $parse_url["pass"] : "") . "@" : "")
            . ((isset($parse_url["host"])) ? $parse_url["host"] : "")
            . ((isset($parse_url["port"])) ? ":" . $parse_url["port"] : "")
            . ((isset($parse_url["path"])) ? $parse_url["path"] : "")
            . ((isset($parse_url["query"]) && !empty($parse_url['query'])) ? "?" . $parse_url["query"] : "")
            . ((isset($parse_url["fragment"])) ? "#" . $parse_url["fragment"] : "");
    }
}
