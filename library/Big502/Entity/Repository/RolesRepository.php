<?php
namespace Big502\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class RolesRepository extends EntityRepository {
    
    public function findAllRoles(){
        
        $dql = 'SELECT g FROM Big502\Entity\RolesEntity g ORDER BY g.name ASC';
        
        $roles = $this->_em->createQuery($dql)->getResult();
        
        return $roles;
    }
}