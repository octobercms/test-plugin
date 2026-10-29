<?php namespace October\Test\Classes;

/**
 * UppercaseRule checks the value is uppercase, with an optional strict mode passed as the first rule parameter.
 */
class UppercaseRule
{
    /**
     * validate passes when the value is uppercase, where strict mode also requires at least one letter.
     */
    public function validate($attribute, $value, $params)
    {
        $value = (string) $value;

        if (($params[0] ?? null) === 'strict' && !preg_match('/\p{L}/u', $value)) {
            return false;
        }

        return mb_strtoupper($value) === $value;
    }

    /**
     * message returns the validation error message, where :mode names the rule mode.
     */
    public function message()
    {
        return 'The :attribute must be uppercase (:mode mode).';
    }

    /**
     * replace fills the :mode placeholder with the rule parameter, testing the replacer fallback on rule classes.
     */
    public function replace($message, $attribute, $rule, $params)
    {
        return str_replace(':mode', $params[0] ?? 'default', $message);
    }
}
