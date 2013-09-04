<?php
namespace IMOControl\M3\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use IMOControl\M3\UserBundle\Model\SystemUser as AbstractSystemUser;
use IMOControl\M3\UserBundle\Model\Interfaces\SystemUserInterface as UserInterface;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
class BaseSystemUser extends AbstractSystemUser 
{
	/**
     * @ORM\PrePersist()
     */
    public function prePersist() {
        $this->updated_at = null;
        $this->created_at = new \DateTime();
    }
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate() {
        $this->updated_at = new \DateTime();
    }
}