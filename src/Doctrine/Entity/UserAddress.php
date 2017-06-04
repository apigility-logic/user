<?php
/**
 * Created by PhpStorm.
 * User: kentkent
 * Date: 2017/6/4
 * Time: 下午2:17
 */
namespace ApigilityLogic\User\Doctrine\Entity;

use ApigilityLogic\Address\Doctrine\Entity\Address;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

/**
 * Class UserAddress
 * @package ApigilityLogic\User\Doctrine\Entity
 * @Entity
 */
class UserAddress extends Address
{
    /**
     * @ManyToOne(targetEntity="User", inversedBy="addresses")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
}