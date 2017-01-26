<?php

class stawka_zw_Test extends Jpk_Test
{
    function test_generuj()
    {
        $raport_path = "raport2.xml";

        $faktura = $this->stworz_fakture();
        $faktura->dataWystawienia = '2017-01-01';
        $faktura->numer = '1/01/2017 FVS';

        $wiersz1 = new \Jpk\FakturaWiersz();
        $wiersz1->nazwa = 'towar1';
        $wiersz1->cenaJednostkowaNetto = 100;
        $wiersz1->ilosc = 1;
        $wiersz1->stawkaVat = 0;
        $wiersz1->stawkaVatOpis = 'zw';
        $faktura->dodajWiersz($wiersz1);

        $wiersz2 = new \Jpk\FakturaWiersz();
        $wiersz2->nazwa = 'towar1';
        $wiersz2->cenaJednostkowaNetto = 200;
        $wiersz2->ilosc = 2;
        $wiersz2->stawkaVat = 0;
        $wiersz2->stawkaVatOpis = 'zw';
        $faktura->dodajWiersz($wiersz2);

        $jpkfa = new \Jpk\Jpkfa($faktura->sprzedawca, "2017-01-01", "2017-01-31", 2206);
        $jpkfa->dodajFakture($faktura);
        $jpkfa->generuj($raport_path);

        $this->assertFileExists($raport_path);

        return $raport_path;
    }

    /**
     * @depends test_generuj
     */
    function test_struktury($raport_path)
    {
        $this->assertXSDValid($raport_path);
    }

    /**
     * @depends test_generuj
     */
    function test_wartosc_faktur($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertEquals(500, $walidator->wartoscFaktur()); // P_15
        $this->assertEquals(500, $walidator->wartoscFakturCtrl()); // faktury ctrl
        $this->assertEquals(500, $walidator->wartoscFakturNetto()); // P_13_1
    }

    /**
     * @depends test_generuj
     */
    function test_wartosc_wierszy($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertEquals(500, $walidator->wartoscWierszyNetto());
        $this->assertEquals(500, $walidator->wartoscWierszyCtrl());
    }
}
