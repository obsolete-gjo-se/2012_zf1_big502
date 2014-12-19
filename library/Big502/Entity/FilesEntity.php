<?php

namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM, 
    Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(
 *     repositoryClass="Big502\Entity\Repository\FilesRepository")
 * @ORM\Table(
 *     name="files")
 */

class FilesEntity extends BaseEntity {

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
     *     name="code",
     *     type="string",
     *     length=255,
     *     nullable=true)
     */ protected $code;
    
//     /** TODO Folder klären
//      * @ORM\ManyToOne(
//      *     targetEntity="FoldersEntity")
//      * @ORM\JoinColumn(
//      *     name="folder_id",
//      *     referencedColumnName="id")
//      */
//     protected $folder;
    
    public function __construct(){
       // $this->folder = new ArrayCollection();
    }
}