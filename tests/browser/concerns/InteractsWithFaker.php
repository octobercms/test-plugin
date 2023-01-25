<?php namespace October\Test\Tests\Browser\Concerns;

/**
 * InteractsWithFaker
 */
trait InteractsWithFaker
{
    /**
     * generateRandomWord
     */
    public function generateRandomWord($length = 6)
    {
        $string = '';
        $vowels = ["a","e","i","o","u"];
        $consonants = [
            'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm',
            'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'
        ];

        $max = $length / 2;
        for ($i = 1; $i <= $max; $i++) {
            $string .= $consonants[rand(0,19)];
            $string .= $vowels[rand(0,4)];
        }

        return $string;
    }

    /**
     * generateRandomSentence
     */
    public function generateRandomSentence($words = 6)
    {
        $string = '';

        for ($i = 1; $i <= $words; $i++) {
            $length = rand(3,6) * 2;
            $string .= ' ' . $this->generateRandomWord($length);
        }

        return trim($string);
    }
}