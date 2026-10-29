<?php namespace October\Test\Classes;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * LowercaseRule checks if the content is lowercase, as a local rule object.
 */
class LowercaseRule implements ValidationRule
{
    /**
     * validate fails the attribute when its value is not lowercase.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strtolower($value) !== $value) {
            $fail('The :attribute must be lowercase.');
        }
    }
}
