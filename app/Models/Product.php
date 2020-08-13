<?php

namespace Shop\Models;

use Doctrine\ORM\EntityRepository;

/**
 * @Entity @Table(name="products")
 */
class Product extends Model
{
    /**
     * @GeneratedValue(strategy="AUTO")
     * @Id
     * @Column(name="id", type="integer", nullable=false)
     */

    protected $id;

    /**
     * @name @Column(type="string", nullable=false)
     */

    protected $name;

    /**
     * @path @Column(type="string", nullable=false)
     */

    protected $path;

    /**
     * @price @Column(type="integer", nullable=false)
     */

    protected $price;
}

 ?>
