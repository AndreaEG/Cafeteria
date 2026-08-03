<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Closure;

class StrongPassword implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) < 5) {
            $fail('La contraseña debe tener al menos 5 caracteres.');
        }
        if (!preg_match('/[A-Z]/', $value)) {
            $fail('La contraseña debe incluir al menos una letra mayúscula.');
        }
    }
}
