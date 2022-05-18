<?php

use PHPUnit\Framework\TestCase;

class eTest extends TestCase{

    /**
     * @testIntegerEq
     */
        public function testIntegerEq(){
        $e= 0;
        $this->assertEquals(0,$e);
    }
}