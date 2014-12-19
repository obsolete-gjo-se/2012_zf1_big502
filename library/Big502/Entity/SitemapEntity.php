<?php
namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM, 
    Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(
 *     repositoryClass="Big502\Entity\Repository\SitemapRepository")
 * @ORM\Table(
 *     name="sitemap")
 */
class SitemapEntity extends BaseEntity {
     
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
     *     name="title",
     *     type="string",
     *     length=255,
     *     unique=true)
     */ protected $title;
    
    /**
     * @ORM\Column(
     *     name="language",
     *     type="string",
     *     length=2)
     */ protected $language;
    
    /**
     * @ORM\Column(
     *     name="keyword",
     *     type="string",
     *     length=255,
     *     unique=true)
     */ protected $keyword;
    
    /**
     * @ORM\Column(
     *     name="descr",
     *     type="string",
     *     length=255,
     *     unique=true)
     */ protected $descr;

    /**
     * @ORM\Column(
     *     name="robots",
     *     type="string",
     *     length=20)
     */ protected $robots;
    
    /**
     * @ORM\Column(
     *     name="url",
     *     type="string",
     *     length=255)
     */ protected $url;
    
    /**
     * @ORM\Column(
     *     name="landingpage",
     *     type="boolean",
     *     nullable=true)
     */ protected $landingpage;
    
    /**
     * @ORM\ManyToMany(
     *     targetEntity="FunctionTestsEntity",
     *     inversedBy="sitemap")
     * @ORM\JoinTable(
     *     name="sitemap_function_tests",
     *     joinColumns={
     *         @ORM\JoinColumn(
     *             name="sitemap_id",
     *             referencedColumnName="id")},
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(
     *             name="functionTests_id",
     *             referencedColumnName="id")})
     */ protected $functionTests;
    
    public function __construct(){
        $this->functionTests = new ArrayCollection();
    }
}