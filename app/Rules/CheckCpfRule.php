<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckCpfRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (! is_numeric($value) || strlen($value) !== 11 || preg_match('/(\d)\1{10}/', $value)) {
            return false;
        }

        for ($i = 9; $i < 11; $i++) {
            for ($j = 0, $k = 0; $k < $i; $k++) {
                $j += $value[$k] * ($i + 1 - $k);
            }

            $j = 10 * $j % 11 % 10;

            if ($value[$k] !== (string) $j) {
                return false;
            }
        }

        return true;
    }

    public function message(): string
    {
        return __('validation.custom.cpf.invalid');
    }
}
