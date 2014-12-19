<?php
namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class ManyToManyInverse extends BaseEntity {
     
    /**
     *  Casace: {"persist", "remove", "merge", "detach", "all"}
     */
    
    /** 
     * @ManyToMany(
     *     targetEntity="",
     *     cascade={"all"},
     *     fetch=LAZY | EXTRA_LAZY | EAGER,
     *     mappedBy="")
     */ protected $ManyToManyInverse;
    
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
