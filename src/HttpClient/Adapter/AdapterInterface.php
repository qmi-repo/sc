<?php

namespace QMILibs\StardustConnectClient\HttpClient\Adapter;

use QMILibs\StardustConnectClient\Exception\ClientApiException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use QMILibs\StardustConnectClient\HttpClient\Request;
use QMILibs\StardustConnectClient\HttpClient\Response;

/**
 * Interface AdapterInterface
 * @package QMILibs\StardustConnectClient\HttpClient\Adapter
 */
interface AdapterInterface
{
    /**
     * Compose a GET request
     *
     * @throws  ClientApiException
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function get(Request $request);

    /**
     * Send a HEAD request
     *
     * @throws  ClientApiException
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function head(Request $request);

    /**
     * Compose a POST request
     *
     * @throws  ClientApiException
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function post(Request $request);

    /**
     * Send a PUT request
     *
     * @throws  ClientApiException
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function put(Request $request);

    /**
     * Send a DELETE request
     *
     * @throws  ClientApiException
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function delete(Request $request);

    /**
     * Send a PATCH request
     *
     * @throws  ClientApiException
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function patch(Request $request);

    /**
     * Return the used client
     *
     * @return mixed
     */
    public function getClient();

    /**
     * Register any specific subscribers
     *
     * @param  EventDispatcherInterface $eventDispatcher
     *
     * @return void
     */
    public function registerSubscribers(EventDispatcherInterface $eventDispatcher);
}
