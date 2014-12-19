<?php
namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class ManyToManyOwning extends BaseEntity {
     
    /**
     *  Casace: {"persist", "remove", "merge", "detach", "all"}
     */
    
    /** 
     * @ManyToMany(
     *     targetEntity="",
     *     cascade={"all"},
     *     fetch=LAZY | EXTRA_LAZY | EAGER,
     *     inversedBy="",
     *     indexBy="")
     * @JoinTable(
     *     name="table1_table2",
     *     joinColumns={
     *         @JoinColumn(
     *             name="table1_id", 
     *             referencedColumnName="id"
     *             unique=true,
     *             nullable=true,
     *             onDelete)},
     *     inverseJoinColumns={
     *         @JoinColumn(
     *             name="table2_id", 
     *             referencedColumnName="id"
     *             unique=true,
     *             nullable=true,
     *             onDelete)})
     */ protected $ManyToManyOwning;
    
    public function __construct(){
        $this->groups = new ArrayCollection();
    }
    
    // oder 
    public function __construct(array $values = null){
        if (!empty($values)) {
            $this->fromArray($values);
        }
    }
    
}
