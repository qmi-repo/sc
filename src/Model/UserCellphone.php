<?php

namespace QMILibs\StardustConnectClient\Model;

/**
 * Class User
 * @package QMILibs\StardustConnectClient\Modelù
 */
class UserCellphone extends AbstractModel implements RegistrableModelInterface
{
    /**
     * @var int
     */
    private $id;

    private $cellphone;

    private $cellphoneVerified;

    /**
     * Properties that are available in the API
     *
     * These properties are hydrated by the ObjectHydrator, all the other properties are handled by the factory.
     *
     * @var array
     */
    public static $properties = [
        "id",
        "cellphone",
        "cellphoneVerified",
    ];

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * @param string $cellphone
     *
     * @return UserCellphone
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getCellphoneVerified()
    {
        return $this->cellphoneVerified;
    }

    /**
     * @param boolean $cellphoneVerified
     *
     * @return UserCellphone
     */
    public function setCellphoneVerified($cellphoneVerified)
    {
        $this->cellphoneVerified = $cellphoneVerified;
        return $this;
    }
}
