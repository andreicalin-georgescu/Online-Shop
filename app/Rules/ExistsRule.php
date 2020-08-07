<?php

namespace Shop\Rules;

use Doctrine\ORM\EntityManager;

use Shop\Rules\RuleInterface;

/**
 * Custom rule class to verify if a field already exists
 */
class ExistsRule implements RuleInterface
{
    protected $db;

    public function __construct(EntityManager $db)
    {
        $this->db = $db;
    }

    public function validate($field, $value, $params, $fields)
    {
        $result = $this->db->getRepository($params[0])
            ->findOneBy([
                $field => $value
            ]);

        return $result === NULL;
    }
}

 ?>
