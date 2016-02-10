<?php

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testSquare()
    {
        $calc = new \AppBundle\Calculator();
        $resultat = $calc->square(12);

        $this->assertNotEquals(1337, $resultat);
        $this->assertEquals(144, $resultat);
    }
}
