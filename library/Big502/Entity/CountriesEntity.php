<?php

namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(
 *     repositoryClass="Big502\Entity\Repository\CountriesRepository",
 *     readOnly=true)
 * @ORM\Table(
 *     name="countries")
 */
class CountriesEntity extends BaseEntity{
    
    /**
     *  @ORM\Id
     *  @ORM\GeneratedValue(
     *      strategy="IDENTITY")
     *  @ORM\Column(
     *      name="id",
     *      type="integer")
     */ protected $id;
    
    /**
     *  @ORM\Column(
     *      name="iso",
     *      type="string",
     *      length =3)
     */ protected $iso;
    
    /**
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=80)
     */ protected $name;
    
    /**
     * @ORM\Column(
     *     name="printable_name",
     *     type="string",
     *     length=80)
     */ protected $printableName;
    
    /**
     * @ORM\Column(
     *     name="iso3",
     *     type="string",
     *     length=3)
     */ protected $iso3;
  
    /**
     * @ORM\Column(
     *     name="num_code",
     *     type="smallint")
     */ protected $numCode;
    
    /**
     * @ORM\OneToMany(
     *     targetEntity="ProvidersEntity",
     *     mappedBy="country")
     */ protected $providers;
    
    public function __construct(){
        $this->providers = new ArrayCollection();
    }
}