<?php

class Faktura_Test extends Jpk_Test
{
    function test_suma_netto()
    {
        $faktura = $this->stworz_fakture();

        $wiersz1 = new \Jpk\FakturaWiersz(); $wiersz1->nazwa = 'towar1';
        $wiersz1->cenaJednostkowaNetto = '100';
        $faktura->dodaj_wiersz($wiersz1);

        $wiersz2 = new \Jpk\FakturaWiersz();
        $wiersz2->nazwa = 'towar2';
        $wiersz2->cenaJednostkowaNetto = '22.8';
        $wiersz2->ilosc = 3;
        $faktura->dodaj_wiersz($wiersz2);

        $this->assertEquals('168.4', $faktura->suma('netto'));
        return $faktura;
    }

    /**
     * @depends test_suma_netto
     */
    function test_suma_brutto($faktura)
    {
        $this->assertEquals('207.13', $faktura->suma('brutto'));
    }

    function test_suma_stawka0()
    {
        $faktura = $this->stworz_fakture();

        $wiersz1 = new \Jpk\FakturaWiersz();
        $wiersz1->nazwa = 'towar1';
        $wiersz1->cenaJednostkowaNetto = '100';
        $wiersz1->stawkaVat = 0;
        $faktura->dodaj_wiersz($wiersz1);

        $this->assertEquals(100, $faktura->suma('netto'), 'netto');
        $this->assertEquals(0, $faktura->suma('podatek'), 'podatek');
        $this->assertEquals(100, $faktura->suma('brutto'), 'brutto');
    }

    function test_sumy_stawek()
    {
        $testowana_stawka = 5;
        $faktura = $this->stworz_fakture();

        $wiersz1 = new \Jpk\FakturaWiersz();
        $wiersz1->nazwa = 'towar1';
        $wiersz1->cenaJednostkowaNetto = '100';
        $wiersz1->stawkaVat = $testowana_stawka;
        $wiersz1->ilosc = 5;
        $faktura->dodaj_wiersz($wiersz1);

        $wiersz2 = new \Jpk\FakturaWiersz();
        $wiersz2->nazwa = 'towar2';
        $wiersz2->cenaJednostkowaNetto = '200';
        $wiersz2->stawkaVat = $testowana_stawka;
        $wiersz2->ilosc = 2;
        $faktura->dodaj_wiersz($wiersz2);

        $wiersz2 = new \Jpk\FakturaWiersz();
        $wiersz2->nazwa = 'towar2';
        $wiersz2->cenaJednostkowaNetto = '1000';
        $wiersz2->stawkaVat = 23;
        $wiersz2->ilosc = 1;
        $faktura->dodaj_wiersz($wiersz2);

        $this->assertEquals(1900, $faktura->suma('netto', 'total'), 'netto total');
        $this->assertEquals(900, $faktura->suma('netto', $testowana_stawka), 'netto 5');
        $this->assertEquals(45, $faktura->suma('podatek', $testowana_stawka), 'podatek 5');
        $this->assertEquals(945, $faktura->suma('brutto', $testowana_stawka), 'brutto 5');
    }

    function test_zaokraglen_brutto()
    {
        $faktura = $this->stworz_fakture();
        $wiersz1 = new \Jpk\FakturaWiersz();
        $wiersz1->nazwa = 'towar1';
        $wiersz1->cenaJednostkowaNetto = '0.13';
        $wiersz1->ilosc = 10;

        $faktura->dodaj_wiersz($wiersz1);
        $this->assertEquals('1.6', $faktura->suma('brutto'));

        $faktura->usun_wiersze();
        $wiersz1->ilosc = 100;
        $faktura->dodaj_wiersz($wiersz1);
        $this->assertEquals('15.99', $faktura->suma('brutto'));

        $faktura->usun_wiersze();
        $wiersz1->ilosc = 1000;
        $faktura->dodaj_wiersz($wiersz1);
        $this->assertEquals('159.9', $faktura->suma('brutto'));
    }
}
