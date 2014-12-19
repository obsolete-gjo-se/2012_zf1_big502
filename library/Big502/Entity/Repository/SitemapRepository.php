<?php
namespace Big502\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class SitemapRepository extends EntityRepository{
    
    public function getAllSites(){
    
        $dql = 'SELECT s FROM Big502\Entity\SitemapEntity s ORDER BY s.url ASC';
    
        $sites = $this->_em->createQuery($dql)->getResult();
        return $sites;
    }
    
    public function getAllFunctionTests(){
    
        $dql = 'SELECT ft FROM Big502\Entity\FunctionTestsEntity ft ORDER BY ft.id';
    
        $functionTestsrepo = $this->_em->createQuery($dql)->getResult();
        return $functionTestsrepo;
    }
    
    public function getAllFunctionTestsForUrl(){
    
//         $dql = 'SELECT ft FROM Big502\Entity\FunctionTestsEntity ft ORDER BY ft.id
//                     JOIN ' ;
        
        $dql = 'SELECT s FROM Big502\Entity\SitemapEntity s
        JOIN s.functionTests ft';
        //WHERE ft.id = ?1';
    
        $functionTestsForUrl = $this->_em->createQuery($dql)->getResult();
        return $functionTestsForUrl;
    }
}