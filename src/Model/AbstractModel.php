<?php

namespace QMILibs\StardustConnectClient\Model;

/**
 * Class AbstractModel
 * @package QMILibs\StardustConnectClient\Model
 */
abstract class AbstractModel
{
    /**
     * List of properties to populate by the ObjectHydrator
     *
     * @var array
     */
    public static $properties = [];

    public static $propertiesPrefix = '';
}
