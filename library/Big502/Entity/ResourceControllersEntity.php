<?php

namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM,
     Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(
 *     repositoryClass="Big502\Entity\Repository\ResourceControllersRepository")
 * @ORM\Table(
 *     name="resource_controllers")
 */

class ResourceControllersEntity extends BaseEntity {
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(
     * strategy="IDENTITY")
     * @ORM\Column(
     * name="id",
     * type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column(
     * name="name",
     * type="string",
     * length=50)
     */
    protected $name;

    /**
     * @ORM\Column(
     * name="module",
     * type="string",
     * length=50)
     */
    protected $module;
    
    /**
     * @ORM\Column(
     * name="description",
     * type="string",
     * length=255)
     */
    protected $description;
    
    /**
     * @ORM\Column(
     * name="activ_on_dev",
     * type="boolean",
     * nullable=true)
     */
    protected $activeOnDev;
    
    /**
     * @ORM\Column(
     * name="activ_on_prod",
     * type="boolean",
     * nullable=true)
     */
    protected $activeOnProduction;
    
    /** TODO Casacade klären
     * @ORM\OneToMany(
     * targetEntity="ResourceActionsEntity",
     * cascade={"persist", "remove"},
     * mappedBy="resourceController")
     */
    protected $resourceActions;
    
    public function __construct(){
        $this->resourceActions = new ArrayCollection();
        $this->rules = new ArrayCollection();
    }
}