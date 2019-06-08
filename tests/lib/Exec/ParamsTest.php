<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Tools\Exec\Params;

class ParamsTest extends TestCase
{

    public function testParamsExists()
    {
        $function = function() { return true; };
        $params = new Params([
            "string"    => 'a',
            "array"     => [
                "int"   => 1,
                "bool"  => true
            ],
            (object) [
                "key"   => "objKey",
                "value" => $function
            ],
            "nullable"  => null
        ]);

        $this->assertEquals($params->string, 'a');
        $this->assertEquals($params->int, 1);
        $this->assertTrue($params->bool);
        $this->assertEquals($params->objKey, $function);
        $this->assertInternalType('callable', $params->objKey);
        $this->assertNull($params->nullable);
    }

    public function testParamsStore()
    {
        $params = new Params();

        $params->test = "test";
        $params->bool = false;
        $params->int = 0;

        $this->assertEquals($params->test, "test");
        $this->assertFalse($params->bool);
        $this->assertEquals($params->int, 0);
    }

}