<?php

namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM, 
    Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(
 *     repositoryClass="Big502\Entity\Repository\ProvidersRepository")
 * @ORM\Table(
 *     name="providers")
 * @ORM\HasLifecycleCallbacks
 */
class ProvidersEntity extends BaseEntity {
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(
     *     strategy="IDENTITY")
     * @ORM\Column(
     *     name="id",
     *     type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=255)
     */
    protected $name;
    
    /**
     * @ORM\Column(
     *     name="email",
     *     type="string",
     *     length=255)
     */
    protected $email;
    
    /**
     * @ORM\Column(
     *     name="active",
     *     type="boolean")
     */
    protected $active;
    
    /**
     * @ORM\Column(
     *     name="created",
     *     type="datetime")
     */
    protected $created;
    
    /**
     * @ORM\Column(
     *     name="updated",
     *     type="datetime")
     */
    protected $updated;
    
    /**
     * @ORM\ManyToOne(
     *     targetEntity="CountriesEntity",
     *     inversedBy="providers")
     * @ORM\JoinColumn(
     *     name="country_id",
     *     referencedColumnName="id")
     */
    protected $country;
    
    /**
     * @ORM\OneToMany(
     *     targetEntity="UsersEntity",
     *     cascade={"persist", "remove"},
     *     mappedBy="provider")
     */
    protected $users;

    public function __construct(){
        $this->users = new ArrayCollection();
        $this->created = $this->updated = new \DateTime("now");
    }
}