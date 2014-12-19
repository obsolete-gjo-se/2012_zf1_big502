<?php
namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM;

class ManyToOneOwing extends BaseEntity {
     
    /**
     *  Casace: {"persist", "remove", "merge", "detach", "all"}
     */
    
    /** 
     * @ORM\ManyToOne(
     *     targetEntity="",
     *     cascade={"all"},
     *     fetch=LAZY | EAGER,
     *     inversedBy="")
     * @ORM\JoinColumn(
     *     name="fieldname_id", 
     *     referencedColumnName="id",
     *     unique=true,
     *     nullable=true,
     *     onDelete)
     */ protected $ManyToOneOnwing;
    
}
