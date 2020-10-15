<?php

namespace QMILibs\StardustConnectClient\Model;

/**
 * Class User
 * @package QMILibs\StardustConnectClient\Modelù
 */
class UserProfile extends AbstractModel implements RegistrableModelInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $middleName;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $email;

    /**
     * @var boolean
     */
    private $emailVerified;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var \DateTime
     */
    private $birthday;

    /**
     * @var \DateTime
     */
    private $lockedAt;

    /**
     * @var \DateTime
     */
    private $disabledAt;

    /**
     * @var City
     */
    private $city;

    /**
     * Properties that are available in the API
     *
     * These properties are hydrated by the ObjectHydrator, all the other properties are handled by the factory.
     *
     * @var array
     */
    public static $properties = [
        "id",
        "name",
        "middleName",
        "surname",
        "slug",
        "email",
        "emailVerified",
        "gender",
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return UserProfile
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     *
     * @return UserProfile
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     *
     * @return UserProfile
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return UserProfile
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return UserProfile
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEmailVerified()
    {
        return $this->emailVerified;
    }

    /**
     * @param bool $emailVerified
     *
     * @return UserProfile
     */
    public function setEmailVerified($emailVerified)
    {
        $this->emailVerified = $emailVerified;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return UserProfile
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     *
     * @return UserProfile
     */
    public function setBirthday(\DateTime $birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLockedAt()
    {
        return $this->lockedAt;
    }

    /**
     * @param \DateTime $lockedAt
     *
     * @return UserProfile
     */
    public function setLockedAt(\DateTime $lockedAt)
    {
        $this->lockedAt = $lockedAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDisabledAt()
    {
        return $this->disabledAt;
    }

    /**
     * @param \DateTime $disabledAt
     *
     * @return UserProfile
     */
    public function setDisabledAt(\DateTime $disabledAt)
    {
        $this->disabledAt = $disabledAt;
        return $this;
    }

    /**
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param City $city
     *
     * @return UserProfile
     */
    public function setCity(City $city)
    {
        $this->city = $city;
        return $this;
    }
}
