<?php

namespace Big502\Entity\Repository;

use Doctrine\ORM\EntityRepository;
//use Doctrine\ORM\Mapping as ORM;

class ResourceControllersRepository extends EntityRepository {

    public function findAllControllers(){
        
        $dql = 'SELECT c FROM Big502\Entity\ResourceControllersEntity c ORDER BY c.module ASC, c.name ASC';
        
        $controllers = $this->_em->createQuery($dql)->getResult();
        
        // TODO Pagination
//         $pagination = new Zend_Paginator(
//                 new DoctrineExtensions\Paginate\PaginationAdapter($controllers));
//         $pagination->setCurrentPageNumber($this->_getPage())
//             ->setItemCountPerPage(20)
//             ->setPageRange(10);
        
//         $this->view->$viewvar = $pagination;
        
        return $controllers;
    }
    
    // public function getPrivilegeIds($flagId){
    // $privileges = array();
    // $dql = 'SELECT PARTIAL p.{id} FROM CC\Entity\Privilege p
    // WHERE p.flag = ?1';
    
    // $privilegesEntities = $this->getEntityManager()
    // ->createQuery($dql)
    // ->setParameter(1, $flagId)
    // ->getResult();
    
    // foreach ($privilegesEntities as $privilege) {
    // $privileges[] = $privilege->getId();
    // }
    
    // return $privileges;
    // }
}