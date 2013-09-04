<?php
namespace IMOControl\M3\UserBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use FOS\UserBundle\Entity\User as FOSUser;
use IMOControl\M3\UserBundle\Model\Interfaces\SystemUserInterface as UserInterface;

abstract class SystemUser extends FOSUser implements UserInterface
{

    /**
     * @ORM\Column(name="two_step_verification_code", type="string", length=50, nullable=true)
     * @var string
     */
    protected $twoStepVerificationCode;

    /**
     * @ORM\Column(name="birthday", type="date", nullable=true)
     * @var \DateTime
     */
    protected $birthday;

	/**
     * @ORM\Column(name="salutation", type="string", length=20, nullable=true)
     * @var string
     */
    protected $salutation;
    
    /**
     * @ORM\Column(name="firstname", type="string", length=50, nullable=true)
     * @var string
     */
    protected $firstname;
    
    /**
     * @ORM\Column(name="lastname", type="string", length=50, nullable=true)
     * @var string
     */
    protected $lastname;

    /**
     * @ORM\Column(name="website", type="string", length=200, nullable=true)
     * @var string
     */
    protected $website;

    /**
     * @ORM\Column(name="gender", type="string", length=1)
     * @var string
     */
    protected $gender = UserInterface::GENDER_UNKNOWN; // set the default to unknown

    /**
     * @ORM\Column(name="locale", type="string", nullable=true)
     * @var string
     */
    protected $locale;

    /**
     * @ORM\Column(name="timezone", type="string", nullable=true)
     * @var string
     */
    protected $timezone;

    /**
     * @ORM\Column(name="phone", type="string", nullable=true)
     * @var string
     */
    protected $phone;
    
    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @var string
     */
    protected $created_at;
    
    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @var string
     */
    protected $updated_at;

    /**
     * @ORM\Column(name="token", type="string", length=100, nullable=true)
     * @var string
     */
    protected $token;
    
    /**
     * Sets the two-step verification code
     *
     * @param string $twoStepVerificationCode
     */
    public function setTwoStepVerificationCode($twoStepVerificationCode)
    {
        $this->twoStepVerificationCode = $twoStepVerificationCode;
    }

    /**
     * Returns the two-step verification code
     *
     * @return string
     */
    public function getTwoStepVerificationCode()
    {
        return $this->twoStepVerificationCode;
    }
    
    /**
     * Sets the creation date
     *
     * @param \DateTime|null $createdAt
     */
    public function setCreatedAt(\DateTime $created_at = null)
    {
        $this->created_at = $created_at;
    }

    /**
     * Returns the creation date
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Sets the last update date
     *
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt(\DateTime $updated_at = null)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * Returns the last update date
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Returns a string representation
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s [%s]", $this->getFullname(), $this->getUsername());
    }

    /**
     * Sets the user groups
     *
     * @param array $groups
     */
    public function setGroups($groups)
    {
        foreach ($groups as $group) {
            $this->addGroup($group);
        }
    }

    /**
     * @param \DateTime $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param string $salutation
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;
    }

    /**
     * @return string
     */
    public function getSalutation()
    {
        return $this->salutation;
    }


    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }


    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getFullname()
    {
        return sprintf("%s %s %s", $this->getSalutation(), $this->getFirstname(), $this->getLastname());
    }

    /**
     * @return array
     */
    public function getRealRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRealRoles(array $roles)
    {
        $this->setRoles($roles);
    }
}