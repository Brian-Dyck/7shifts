<?php
/**
 * @author Brian Dyck
 */

declare(strict_types=1);
namespace brianDyck\shifts;

/**
 * Class Calculator
 * @package brianDyck\shifts
 * Simple string calculator
 *
 */
final class Calculator
{
    /**
     * Adds the integers and returns the result
     * @param String $numbers - A comma separated list of integers
     * @return int - the resulting sum
     */
    function Add(String $numbers) : int
    {
        //part 3: custom delimiter
        //default delimiter is a comma
        $delimiter = ',';

        //if string starts with double slash get custom delimiter
        if(preg_match("/^\/\/.+\n/", $numbers))
        {
            //get delimiter
            $delimiter = substr($numbers, 2, strpos($numbers, "\n") - 2);

            //remove delimiter control code from start of string
            $numbers = preg_replace("/^\/\/.+\n/", "", $numbers);

            //bonus 3: multiple delimiters
            // if delimiter is list of delimiters, then replace all delimiters with comma
            if(preg_match("/.+,.+/", $delimiter))
            {
                $delimiter = explode(",", $delimiter);
                $numbers = str_replace($delimiter, ",", $numbers);
                $delimiter = ",";
            }
        }

        //explode values into array
        $values = explode($delimiter, $numbers);

        //remove white space
        $values = preg_replace("/\s+/", "", $values);

        //part 4:
        //test for negative numbers
        $this->checkForNegativeInts($values);

        //bonus 1:
        //remove values > 1000
        $values = array_filter($values, function ($x) {return $x <= 1000;} );

        //return sum of values
        return array_sum($values);

    }

    /**
     * Throws exception if array contains any negative ints
     * @param array $intArray - array of ints
     * @throws \Exception - if any values are negative
     */
    function checkForNegativeInts(array $intArray)
    {
        //get array of negative ints
        $negativeIntArray = array_filter($intArray, function ($x) {return $x < 0;} );
        //if there are any, throw exception
        if(!empty($negativeIntArray))
        {
            throw new \Exception("Negatives not allowed. " . implode(", ", $negativeIntArray));
        }
    }
}