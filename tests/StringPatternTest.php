<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Src\StringPattern;

final class StringPatternTest extends TestCase
{
    public function getValidStrings()
    {
        return [
            ['()'],
            ['[()]'],
            ['{[()]}'],
            ['()[]{}'],
            ['([])[()]'],
            ['([])({})'],
            ['([]){{}}({})'],
            ['[({({{{}}})})]'],
            ['([{()}])[(((({{[[]]}}))))]']
        ];
    }

    public function getInvalidStrings()
    {
        return [
            ['())'],
            [')(][}{'],
            ['[{]}'],
            ['[()}{]'],
            [''],
            [' '],
            [123456],
            ['abcdef'],
            ['([{()}])[(((({{[[]]}}))))]([{()}])[(((({{[[]]}}))))]([{()}])[(((({{[[]]}}))))]([{()}])[(((({{])[(((({{])[']
        ];
    }

    /**
     * @dataProvider getValidStrings
     */
    public function testValidStrings($s)
    {
       $test = new StringPattern();

       $this->assertTrue($test->isValid($s));
    }

    /**
     * @dataProvider getInvalidStrings
     */
    public function testInvalidStrings($s)
    {
       $test = new StringPattern();

       $this->assertFalse($test->isValid($s));
    }
}