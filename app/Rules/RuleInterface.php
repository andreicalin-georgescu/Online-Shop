<?php

namespace Shop\Rules;

/**
 * Interface to outline the validation method for
 * custom rules
 */
interface RuleInterface
{
    public function validate($field, $value, $params, $fields);
}


 ?>
