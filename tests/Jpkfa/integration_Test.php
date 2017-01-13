<?php

class integration_Test extends Jpk_Test
{
    function test_generuj()
    {
        $raport_path = "raport.xml";

        $faktura = $this->stworz_fakture();
        $faktura->DataWystawienia = '2017-01-01';
        $faktura->Numer = '123/01/2017 FVS';

        $wiersz1 = new \Jpk\Faktura_wiersz();
        $wiersz1->nazwa = 'towar1';
        $wiersz1->cenaJednostkowNetto = 100;

        $faktura->dodaj_wiersz($wiersz1);

        $wiersz2 = new \Jpk\Faktura_wiersz();
        $wiersz2->nazwa = 'towar 2';
        $wiersz2->cenaJednostkowNetto = 200;
        $wiersz2->ilosc = 3;
        $faktura->dodaj_wiersz($wiersz2);

        $jpkfa = new \Jpk\Jpkfa($faktura->sprzedawca, "2017-01-01", "2017-01-31", 2206);
        $jpkfa->dodaj_fakture($faktura);
        $jpkfa->generuj($raport_path);

        $this->assertFileExists($raport_path);

        return $raport_path;
    }

    /**
     * @depends test_generuj
     */
    function test_struktury($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertTrue(
            $walidator->sprawdz_zgodnosc_struktury(__DIR__ .'/../../spec/schemat_jpk_fa.xsd'), 
            'niezgodny z formalna struktura xsd'
        );
    }

    /**
     * @depends test_generuj
     */
    function test_liczba_faktur($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertTrue($walidator->sprawdz_liczbe_faktur());
    }

    /**
     * @depends test_generuj
     */
    function test_wartosc_faktur($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertTrue($walidator->sprawdz_wartosc_faktur());
    }
}
