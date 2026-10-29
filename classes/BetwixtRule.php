<?php namespace October\Test\Classes;

/**
 * BetwixtRule checks the content length is between the start and end parameters.
 */
class BetwixtRule
{
    /**
     * validate passes when the value length is greater than the start parameter and less than the end parameter.
     */
    public function validate($attribute, $value, $params)
    {
        [$start, $end] = $params;

        return strlen($value) > $start && strlen($value) < $end;
    }

    /**
     * message returns the validation error message, where :start and :end are filled by replace.
     */
    public function message()
    {
        return 'The :attribute must be between :start and :end.';
    }

    /**
     * replace fills the :start and :end placeholders with the rule parameters.
     */
    public function replace($message, $attribute, $rule, $params)
    {
        [$start, $end] = $params;

        $message = str_replace(':start', $start, $message);

        $message = str_replace(':end', $end, $message);

        return $message;
    }
}
