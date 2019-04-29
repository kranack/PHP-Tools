<?php
declare(strict_types=1);

require_once("vendor/autoload.php");

use Tools\Utils\StringUtils;
use PHPUnit\Framework\TestCase;

class StringUtilsTest extends TestCase
{

    /**
     * @dataProvider stringStartsProvider
     */
    public function testStringStartsWith($needle, $haystack, $shouldBe)
    {
        $this->assertEquals(StringUtils::startsWith($haystack, $needle), $shouldBe);
    }

    /**
     * @dataProvider stringEndsProvider
     */
    public function testStringEndsWith($needle, $haystack, $shouldBe)
    {
        $this->assertEquals(StringUtils::endsWith($haystack, $needle), $shouldBe);
    }

    public function stringStartsProvider()
    {
        return [
            'lorem ipsum'   => ['Lorem ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', true],
            'lorem'         => ['Lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', true],
            'empty string'  => ['', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', true],
            'space'         => [' ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', false],
            'case'          => ['LOREM ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', false],
            'lazy fox'      => ['Lazy fox', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', false]
        ];
    }

    public function stringEndsProvider()
    {
        return [
            'lorem ipsum'   => ['adipiscing elit.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', true],
            'lorem'         => ['elit.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', true],
            'empty string'  => ['', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', true],
            'space'         => [' ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', false],
            'case'          => ['adipiscing eliT.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', false],
            'lazy fox'      => ['Lazy fox', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', false]
        ];
    }

}