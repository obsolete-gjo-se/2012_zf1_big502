<?php

namespace Big502\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ResourceActionsRepository extends EntityRepository {
    
    public function findAllActions(){
        
        //TODO $dql RF (aufstrippen?)
        $dql = 'SELECT a FROM Big502\Entity\ResourceActionsEntity a JOIN a.resourceController c ORDER BY c.name ASC, a.name ASC';
    
        $actions = $this->_em->createQuery($dql)->getResult();
        return $actions;
    }
}