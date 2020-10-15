<?php

namespace QMILibs\StardustConnectClient\Model\Common\QueryParameter;

/**
 * Interface QueryParameterInterface
 * @package QMILibs\StardustConnectClient\Model\Common\QueryParameter
 */
interface QueryParameterInterface
{
    /**
     * @return string
     */
    public function getKey();

    /**
     * @return string
     */
    public function getValue();
}
