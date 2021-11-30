<?php namespace October\Test\Classes;

/**
 * BetwixtRule checks if the content is between two ferns.
 */
class BetwixtRule
{
    /**
     * validate between start and end parameters.
     */
    public function validate($attribute, $value, $params)
    {
        [$start, $end] = $params;

        return strlen($value) > $start && strlen($value) < $end;
    }

    /**
     * message gets the validation error message.
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be between :start and :end.';
    }

    /**
     * replace defines custom placeholder replacements.
     * @return string
     */
    public function replace($message, $attribute, $rule, $params)
    {
        [$start, $end] = $params;

        $message = str_replace(':start', $start, $message);

        $message = str_replace(':end', $end, $message);

        return $message;
    }
}
