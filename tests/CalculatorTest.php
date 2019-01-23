<?php
/**
 * @author Brian Dyck
 */
declare(strict_types=1);
namespace brianDyck\shifts;
use PHPUnit\Framework\TestCase;

require_once "../src/Calculator.php";

final class CalculatorTest extends TestCase
{
    /**
     * setup Calculator for all tests to use
     */
    function setUp()
    {
        $this->calc = new Calculator();
    }

    /**
     * Test that empty string returns int 0
     */
    function testEmptyStringReturns0()
    {
        $this->assertEquals(0, $this->calc->add("") );
        $this->assertTrue( is_int($this->calc->add("")) );
    }

    /**
     * Test that "1,2,5" returns int 8
     */
    function test125()
    {
        $this->assertEquals(8, $this->calc->add("1,2,5"));
        $this->assertTrue( is_int($this->calc->add("1,2,5")) );
    }

    /**
     * Test that whitespace is ignored
     */
    function testWhiteSpaceInString()
    {
        $this->assertEquals(6, $this->calc->add("1\n,2,3"));
        $this->assertEquals(15, $this->calc->add("1\n \t0, 2 ,\n\n\n 3 "));
    }

    /**
     * Test that strings starting with // use custom delimiter
     */
    function testCustomDelimiter()
    {
        $this->assertEquals(8, $this->calc->add("//;\n1;3;4"));
        $this->assertEquals(6, $this->calc->add("//$\n1$2$3"));
        $this->assertEquals(13, $this->calc->add("//@\n2@3@8"));
    }

    /**
     * tests that negative numbers will throw an exception
     */
    function testNegativesThrowException()
    {
        $this->expectExceptionMessage("Negatives not allowed. -2, -3");

        $this->calc->add("//;\n1;-2;-3");
    }

    /**
     * tests that numbers larger than 1000 are ignored
     */
    function testNumbersGreater1000Ignored()
    {
        $this->assertEquals(2, $this->calc->add("2,1001"));
    }

    /**
     * tests that delimiter can be arbitrary length
     */
    function testMultiCharacterDelimiter()
    {
        $this->assertEquals(6, $this->calc->add("//***\n1***2***3"));
    }

    /**
     * tests that multiple delimiters can be used
     */
    function testMultipleDelimiters()
    {
        $this->assertEquals(6, $this->calc->add("//$,@\n1$2@3"));
        $this->assertEquals(6, $this->calc->add("//..$,@!#\n1..$2@!#3"));
    }




}
