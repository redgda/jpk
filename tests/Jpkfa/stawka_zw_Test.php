<?php

class stawka_zw_Test extends Jpk_Test
{
    function test_generuj()
    {
        $raport_path = "raport2.xml";

        $faktura = $this->stworz_fakture();
        $faktura->DataWystawienia = '2017-01-01';
        $faktura->Numer = '1/01/2017 FVS';

        $wiersz1 = new \Jpk\FakturaWiersz();
        $wiersz1->nazwa = 'towar1';
        $wiersz1->cenaJednostkowaNetto = 100;
        $wiersz1->ilosc = 1;
        $wiersz1->stawkaVat = 0;
        $wiersz1->stawkaVatOpis = 'zw';
        $faktura->dodaj_wiersz($wiersz1);

        $wiersz2 = new \Jpk\FakturaWiersz();
        $wiersz2->nazwa = 'towar1';
        $wiersz2->cenaJednostkowaNetto = 200;
        $wiersz2->ilosc = 2;
        $wiersz2->stawkaVat = 0;
        $wiersz2->stawkaVatOpis = 'zw';
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
    function test_wartosc_faktur($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertEquals(500, $walidator->wartosc_faktur()); // P_15
        $this->assertEquals(500, $walidator->wartosc_faktur_ctrl()); // faktury ctrl
        $this->assertEquals(500, $walidator->wartosc_faktur_netto()); // P_13_1
    }

    /**
     * @depends test_generuj
     */
    function test_wartosc_wierszy($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertEquals(500, $walidator->wartosc_wierszy_netto());
        $this->assertEquals(500, $walidator->wartosc_wierszy_ctrl());
    }
}
