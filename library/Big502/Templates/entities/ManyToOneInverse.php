<?php
namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class ManyToOneInverse extends BaseEntity {
     

    
    /** 
     * @ORM\OneToMany(
     *     targetEntity="",
     *     cascade={"all"},
     *     fetch=LAZY | EXTRA_LAZY | EAGER,
     *     orphanRemoval=true,
     *     indexBy="",
     *     mappedBy="")
     */ protected $ManyToOneInverse;
    
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
