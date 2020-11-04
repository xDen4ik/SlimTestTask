<?php

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;


final class EmailEvalible extends AbstractRule
{
    public function validate($input): bool
    {
        return User::where('email', $input)->count() === 0;
    }
}
