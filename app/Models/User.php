<?php

namespace Shop\Models;

/**
 * @Entity @Table(name="users")
 */
class User extends Model
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
     * @email @Column(type="string", nullable=false)
     */

    protected $email;

    /**
     * @password @Column(type="string", nullable=false)
     */

    protected $password;

    /**
     * @remember_token @Column(type="string", nullable=false)
     */

    protected $remember_token;

    /**
     * @remember_identifier @Column(type="string", nullable=false)
     */

    protected $remember_identifier;

}

 ?>
