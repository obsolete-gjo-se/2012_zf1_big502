<?php

namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM, 
    Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(
 *     repositoryClass="Big502\Entity\Repository\ResourceActionsRepository")
 * @ORM\Table(
 *     name="resource_actions")
 */

class ResourceActionsEntity extends BaseEntity {

    /**
     *  @ORM\Id
     *  @ORM\GeneratedValue(
     *      strategy="IDENTITY")
     *  @ORM\Column(
     *      name="id",
     *      type="integer")
     */ protected $id;
    
    
    /**
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=50)
     */ protected $name;
    
    /**
     * @ORM\Column(
     *     name="description",
     *     type="string",
     *     length=255)
     */ protected $description;
    
    /**
     * @ORM\ManyToOne(
     *     targetEntity="ResourceControllersEntity",
     *     inversedBy="resourceActions")
     * @ORM\JoinColumn(
     *     name="resource_controller_id",
     *     referencedColumnName="id")
     */
    protected $resourceController;
    
    /**
     * @ORM\OneToMany(
     *     targetEntity="RulesEntity",
     *     mappedBy="resourceAction")
     */ protected $rules;
    
    public function __construct(){
        $this->resourceController = new ArrayCollection();
    }
}