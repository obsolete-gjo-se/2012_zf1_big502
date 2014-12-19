<?php

namespace Big502\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class FilesRepository extends EntityRepository {

    public function findAllFiles(){
        
        $dql = 'SELECT f FROM Big502\Entity\FilesEntity f ORDER BY f.name ASC';
        
        $files = $this->_em->createQuery($dql)->getResult();
        return $files;
    }
}