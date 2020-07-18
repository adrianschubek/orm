<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

use adrianschubek\Database\Drivers\PdoDriver;

/**
 * Copyright (c) 2019. Adrian Schubek
 * https://adriansoftware.de
 */
class Test2 extends PHPUnit\Framework\TestCase
{
    public function test_can_create_pdo()
    {
        $con = new PdoDriver('test', 'localhost', 'root', '');

        $this->assertInstanceOf(PdoDriver::class, $con);
    }

    public function test_()
    {
        $con = new PdoDriver('test', 'localhost', 'root', '');



        $this->assertTrue(true);
    }
}
