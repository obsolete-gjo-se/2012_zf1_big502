<?php
namespace Big502\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(
 *     repositoryClass="Big502\Entity\Repository\EntityRepository",
 *     readOnly=true)
 * @ORM\Table(
 *     name="",
 *     uniqueConstraints={@UniqueConstraint(name="",columns={""})},
 *     indexes={@index(name="", columns={"", ""})})
 */
class Entity extends BaseEntity {
     
    /**
     *  Types: string, integer, smallint, bigint, boolean, decimal, date, time, datetime, text, object, array, float
     */

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
     *     name="",
     *     type="",
     *     length=, precision=, scale=,
     *     unique=true,
     *     nullable=true)
     */ protected $fieldname;
    
}
