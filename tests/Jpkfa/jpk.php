<?php

class jpk_Test extends PHPUnit_Framework_TestCase
{
    function test_one()
    {
        $raport_path = "jpk_fa.xml";
        $podmiot = new \Jpk\Podmiot("Trojmiasto.pl");
        $jpkfa = new \Jpk\Jpkfa($podmiot, "2017-01-01", "2017-01-31");

        $klient = new \Jpk\Podmiot("Firma testowa");
        $faktura1 = new \Jpk\Faktura($podmiot, $klient);
        $wiersz1 = new \Jpk\Faktura_wiersz("usluga przyklad");
        $wiersz2 = new \Jpk\Faktura_wiersz("produkt przyklad");
        $faktura1->dodaj_wiersz($wiersz1);
        $faktura1->dodaj_wiersz($wiersz2);
        $jpkfa->dodaj_fakture($faktura1);

        $raport = $jpkfa->generuj($raport_path);
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertTrue($walidator->sprawdz_poprawnosc());
    }
}
