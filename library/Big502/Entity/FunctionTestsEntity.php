<?php
namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM, 
    Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(
 *     repositoryClass="Big502\Entity\Repository\FunctionTestsRepository")
 * @ORM\Table(
 *     name="function_tests")
 */
class FunctionTestsEntity extends BaseEntity {
     
    /**
     *  @ORM\Id
     *  @ORM\GeneratedValue(
     *      strategy="IDENTITY")
     *  @ORM\Column(
     *      name="id",
     *      type="integer")
     */ protected $id;
    
    /**
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=255)
     */ protected $name;
    
    /**
     * @ORM\Column(
     *     name="descr",
     *     type="string",
     *     length=255)
     */ protected $descr;
    
    /**
     * @ORM\ManyToMany(
     *     targetEntity="SitemapEntity",
     *     mappedBy="functionTests")
     */ protected $sitemap;
    
    public function __construct(){
        $this->sitemap = new ArrayCollection();
    }

}