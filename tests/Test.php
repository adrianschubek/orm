<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

use adrianschubek\Database\Connection\PdoConnection;

/**
 * Copyright (c) 2019. Adrian Schubek
 * https://adriansoftware.de
 */
class Test2 extends PHPUnit\Framework\TestCase
{
    public function test_can_create_pdo()
    {
        $con = new PdoConnection('test', 'localhost', 'root', '');

        $this->assertInstanceOf(PdoConnection::class, $con);
    }

    public function test_()
    {
        $con = new PdoConnection('test', 'localhost', 'root', '');



        $this->assertTrue(true);
    }
}
