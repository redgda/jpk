<?php

class integration_Test extends Jpk_Test
{
    function test_generuj()
    {
        $raport_path = "raport.xml";

        $faktura = $this->stworz_fakture();
        $faktura->dataWystawienia = '2017-01-01';
        $faktura->numer = '123/01/2017 FVS';

        $wiersz1 = new \Jpk\FakturaWiersz();
        $wiersz1->nazwa = 'towar1';
        $wiersz1->cenaJednostkowaNetto = 100;
        $wiersz1->ilosc = 1;
        $faktura->dodajWiersz($wiersz1);

        $wiersz2 = new \Jpk\FakturaWiersz();
        $wiersz2->nazwa = 'towar 2';
        $wiersz2->cenaJednostkowaNetto = 200;
        $wiersz2->ilosc = 3;
        $faktura->dodajWiersz($wiersz2);

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
        $this->assertEquals(1, $walidator->liczba_faktur());
        $this->assertEquals(1, $walidator->liczba_faktur_ctrl());
    }

    /**
     * @depends test_generuj
     */
    function test_wartosc_faktur($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertEquals(861, $walidator->wartosc_faktur()); // P_15
        $this->assertEquals(700, $walidator->wartosc_faktur_ctrl()); // 
        $this->assertEquals(700, $walidator->wartosc_faktur_netto()); // P_15
    }

    /**
     * @depends test_generuj
     */
    function test_wartosc_wierszy($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertEquals(700, $walidator->wartosc_wierszy_netto());
        $this->assertEquals(700, $walidator->wartosc_wierszy_ctrl());
    }

    /**
     * @depends test_generuj
     */
    function test_ilosc_wierszy($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertEquals(2, $walidator->liczba_wierszy());
        $this->assertEquals(2, $walidator->liczba_wierszy_ctrl());
    }

    /**
     * @depends test_generuj
     */
    function test_daty($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertTrue($walidator->sprawdz_daty());
    }

    /**
     * @depends test_generuj
     */
    function test_numery($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertTrue($walidator->sprawdz_numery());
    }

}
