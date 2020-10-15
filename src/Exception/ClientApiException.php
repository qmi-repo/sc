<?php

namespace QMILibs\StardustConnectClient\Exception;

use QMILibs\StardustConnectClient\HttpClient\Request;
use QMILibs\StardustConnectClient\HttpClient\Response;

/**
 * Class ClientApiException
 * @package QMILibs\StardustConnectClient\Exception
 */
class ClientApiException extends \RuntimeException
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * Create the exception
     *
     * @param int             $code
     * @param string          $message
     * @param Request|null    $request
     * @param Response|null   $response
     * @param \Exception|null $previous
     */
    public function __construct($code, $message, $request = null, $response = null, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param  Request $request
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param  Response $response
     * @return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }
}
