<?php

namespace QMILibs\StardustConnectClient\Common;

use QMILibs\StardustConnectClient\Exception\RuntimeException;
use QMILibs\StardustConnectClient\Model\AbstractModel;

/**
 * Class ObjectHydrator
 * @package QMILibs\StardustConnectClient\Common
 */
class ObjectHydrator
{
    /**
     * Hydrate the object with data
     *
     * @param  AbstractModel $object
     * @param  array         $data
     *
     * @return AbstractModel
     * @throws RuntimeException
     */
    public function hydrate(AbstractModel $object, $data = [])
    {
        if (!empty($data)) {
            foreach ($data as $k => $v) {

                if (in_array($k, $object::$properties)) {

                    $method = $this->camelize(
                        sprintf('set_%s', str_replace($object::$propertiesPrefix, '', $k))
                    );

                    if (!is_callable([$object, $method])) {
                        throw new RuntimeException(sprintf(
                            'Trying to call method "%s" on "%s" but it does not exist or is private.',
                            $method,
                            get_class($object)
                        ));
                    } else {
                        $object->$method($v);
                    }
                }
            }
        }

        return $object;
    }

    /**
     * Transforms an under_scored_string to a camelCasedOne
     *
     * @see https://gist.github.com/troelskn/751517
     *
     * @param  string $candidate
     *
     * @return string
     */
    public function camelize($candidate)
    {
        return lcfirst(
            implode(
                '',
                array_map(
                    'ucfirst',
                    array_map(
                        'strtolower',
                        explode(
                            '_',
                            $candidate
                        )
                    )
                )
            )
        );
    }
}
