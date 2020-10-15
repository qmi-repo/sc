<?php

namespace QMILibs\StardustConnectClient\ModelManager;

use QMILibs\StardustConnectClient\Exception\UnregisteredModelException;
use QMILibs\StardustConnectClient\Model\RegistrableModelInterface;

/**
 * Class ModelManager
 * @package QMILibs\StardustConnectClient\Model
 */
class ModelManager
{
    /**
     * @var array
     */
    private $_identityMap;

    /**
     * Call this method to get singleton
     *
     * @return ModelManager
     */
    public static function instance()
    {
        static $inst = NULL;
        if ($inst === NULL) {
            $inst = new ModelManager();
        }
        return $inst;
    }

    /**
     * Private ctor so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        $this->_identityMap = [];
    }

    /**
     * @param RegistrableModelInterface $model
     *
     * @return RegistrableModelInterface
     */
    public function register(RegistrableModelInterface &$model)
    {
        $classObj = get_class($model);
        if (!$this->hasClassRegistry($classObj)) {
            $this->createClassRegistry($classObj);
        }
        $this->_identityMap[$classObj][$model->getId()] = $model;
        return $model;
    }

    /**
     * @param int    $id
     * @param string $class
     *
     * @return mixed
     */
    public function getReference($id, $class)
    {
        if (!isset($this->_identityMap[$class])) {
            throw new UnregisteredModelException('Class ' . $class . ' not founded in ModelManager');
        }
        if (!isset($this->_identityMap[$class][$id])) {
            throw new UnregisteredModelException('Object of class ' . $class . ' with id #' . $id . ' not founded in ModelManager');
        }

        return $this->_identityMap[$class][$id];
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    private function hasClassRegistry($class)
    {
        return isset($this->_identityMap[$class]);
    }

    /**
     * @param string $class
     */
    private function createClassRegistry($class)
    {
        $this->_identityMap[$class] = [];
    }
}
