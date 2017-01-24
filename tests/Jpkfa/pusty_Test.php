<?php

class pusty_Test extends Jpk_Test
{
    function test_generuj()
    {
        $raport_path = "raport4.xml";
        $jpkfa = new \Jpk\Jpkfa($this->stworz_podmiot(), "2017-01-01", "2017-01-31", 2206);
        $this->assertFalse($jpkfa->generuj($raport_path));
        $this->assertNotEmpty($jpkfa->ostatniBlad());
    }
}
