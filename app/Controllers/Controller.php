<?php

namespace Shop\Controllers;

use Valitron\Validator;

use Shop\Exceptions\ValidationException;

/**
 * Base Controller abstract class to implement validation
 */
abstract class Controller
{
    public function validate($request, array $rules)
    {
        $validator = new Validator($request->getParsedBody());

        $validator->mapFieldsRules($rules);

        if (!$validator->validate()) {
            throw new ValidationException($request, $validator->errors());
        }

        return $request->getParsedBody();
    }
}

 ?>
