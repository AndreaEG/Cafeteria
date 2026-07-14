<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Closure;

class StrongPassword implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) < 10) {
            $fail('La contraseña debe tener al menos 10 caracteres.');
        }
        if (!preg_match('/[A-Z]/', $value)) {
            $fail('La contraseña debe incluir al menos una letra mayúscula.');
        }
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>_\-]/', $value)) {
            $fail('La contraseña debe incluir al menos un carácter especial.');
        }
    }
}
