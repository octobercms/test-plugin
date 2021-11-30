<?php namespace October\Test\Classes;

/**
 * UppercaseRule checks if the content is uppercase.
 */
class UppercaseRule
{
    /**
     * validate determines if the validation rule passes.
     * @param string $attribute
     * @param mixed $value
     * @param array $params
     * @return bool
     */
    public function validate($attribute, $value, $params)
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
