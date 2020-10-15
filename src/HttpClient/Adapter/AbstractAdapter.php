<?php

namespace QMILibs\StardustConnectClient\HttpClient\Adapter;

use QMILibs\StardustConnectClient\Exception\ClientApiException;
use QMILibs\StardustConnectClient\HttpClient\Request;
use QMILibs\StardustConnectClient\HttpClient\Response;

/**
 * Class AbstractAdapter
 * @package QMILibs\StardustConnectClient\HttpClient\Adapter
 */
abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * Create the unified exception to throw
     *
     * @param  Request   $request
     * @param  Response  $response
     * @param \Exception $previous
     *
     * @return ClientApiException
     */
    protected function createApiException(Request $request, Response $response, \Exception $previous = NULL)
    {
        $errors = json_decode((string)$response->getBody());

        return new ClientApiException(
            isset($errors->status_code) ? $errors->status_code : $response->getCode(),
            isset($errors->status_message) ? $errors->status_message : NULL,
            $request,
            $response,
            $previous
        );
    }
}
