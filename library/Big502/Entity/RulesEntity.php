<?php
namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM, 
    Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(
 *     repositoryClass="Big502\Entity\Repository\RulesRepository")
 * @ORM\Table(
 *     name="rules")
 */

class RulesEntity extends BaseEntity {
    
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
     *     name="allow",
     *     type="boolean")
     */ protected $allow;
    
    /**
     * @ORM\ManyToOne(
     *     targetEntity="ResourceActionsEntity",
     *     inversedBy="rules")
     * @ORM\JoinColumn(
     *     name="resource_action_id",
     *     referencedColumnName="id")
     */
    protected $resourceAction;
    
    /**
     * @ORM\ManyToOne(
     *     targetEntity="RolesEntity",
     *     inversedBy="rules")
     * @ORM\JoinColumn(
     *     name="role_id",
     *     referencedColumnName="id")
     */
    protected $role;
    
    public function __construct(){
//         $this->resourceAction = new ArrayCollection();
//         $this->resourceController = new ArrayCollection();
//         $this->role = new ArrayCollection();
    }
}