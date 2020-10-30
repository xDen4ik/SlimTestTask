<?php

namespace App\Validation;

use Respect\Validation\Validator as Recpect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    public function validate($request, $rules = [])
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMEssages();
            }
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    public function failed()
    {
        return !empty($this->errors);
    }
}
