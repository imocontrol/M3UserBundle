<?php
namespace IMOControl\M3\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Entity\Group  as AbstractSystemGroup;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
class BaseSystemGroup extends AbstractSystemGroup 
{
    /**
     * Represents a string representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName() ?: '';
    }
}