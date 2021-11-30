<?php namespace October\Test\Classes;

/**
 * LowercaseRule checks if the content is uppercase.
 */
class LowercaseRule implements \Illuminate\Contracts\Validation\Rule
{
    /**
     * passes
     */
    public function passes($attribute, $value)
    {
        return $this->validate($attribute, $value, []);
    }

    /**
     * validate determines if the validation rule passes.
     * @param string $attribute
     * @param mixed $value
     * @param array $params
     * @return bool
     */
    public function validate($attribute, $value, $params)
    {
        return strtolower($value) === $value;
    }

    /**
     * message gets the validation error message.
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be lowercase.';
    }
}
