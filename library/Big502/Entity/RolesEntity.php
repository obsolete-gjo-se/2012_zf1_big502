<?php

namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM, 
    Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(
 *     repositoryClass="Big502\Entity\Repository\RolesRepository")
 * @ORM\Table(
 *     name="roles")
 */
class RolesEntity extends BaseEntity{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(
     *     strategy="IDENTITY")
     * @ORM\Column(
     *     name="id",
     *     type="integer")
     */ protected $id;

    /**
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=255)
     */ protected $name;
    
    /**
     * @ORM\ManyToOne(
     *     targetEntity="RolesEntity",
     *     inversedBy="children")
     * @ORM\JoinColumn(
     *     name="parent_id",
     *     referencedColumnName="id")
     */ protected $parent;
    
    /**
     * @ORM\OneToMany(
     *     targetEntity="RolesEntity",
     *     mappedBy="parent")
     */ protected $children;
    
    /**
     * @ORM\OneToMany(
     *     targetEntity="RulesEntity",
     *     mappedBy="role")
     */ protected $rules;    
    
    /**
     * @ORM\ManyToMany(
     *     targetEntity="UsersEntity", 
     *     mappedBy="roles")
     */ protected $users;
    
    public function __construct(){
        $this->children = new ArrayCollection();
        $this->rules = new ArrayCollection();
        $this->users = new ArrayCollection();
    }
}