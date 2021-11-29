<?php namespace October\Test\Rules;

/**
 * UppercaseRule checks if the content is uppercase.
 */
class UppercaseRule extends \October\Rain\Validation\Rule
{
    /**
     * passes determines if the validation rule passes.
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return strtoupper($value) === $value;
    }

    /**
     * message gets the validation error message.
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be uppercase (:foo).';
    }

    /**
     * replace defines custom placeholder replacements.
     * @return string
     */
    public function replace($message, $attribute, $rule, $params)
    {
        return str_replace(':foo', 'bar', $message);
    }
}
