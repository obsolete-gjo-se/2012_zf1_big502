<?php
namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM;


class OneToOneOwning extends BaseEntity {
     
    /**
     *  Casace: {"persist", "remove", "merge", "detach", "all"}
     */
    
    /**
     * @OneToOne(
     *     targetEntity="",
     *     cascade={"all"},
     *     fetch=LAZY | EAGER,
     *     orphanRemoval=true,
     *     inversedBy="")
     * @JoinColumn(
     *     name="fieldname_id", 
     *     referencedColumnName="id",
     *     unique=true,
     *     nullable=true,
     *     onDelete)
     */ protected $OneToOneOwning;
    
}
