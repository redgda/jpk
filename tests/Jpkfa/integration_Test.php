<?php

class integration_Test extends PHPUnit_Framework_TestCase
{
    function test_one()
    {
        $raport_path = "jpk_fa.xml";

        $sprzedawca = new \Jpk\Podmiot();
        $sprzedawca->Nazwa = 'Trojmiasto.pl Sp. z o.o.';
        $sprzedawca->Nip = 5833012490;
        $sprzedawca->Regon = 220563678;
        $sprzedawca->Ulica = 'Wały Piastowskie';
        $sprzedawca->NrDomu = '1';
        $sprzedawca->KodPocztowy = '80-855';
        $sprzedawca->Kod_kraju = 'PL';
        $sprzedawca->Wojewodztwo = 'POMORSKIE';
        $sprzedawca->Powiat = 'Gdańsk';
        $sprzedawca->Miejscowosc = 'Gdańsk';
        $sprzedawca->Gmina = 'Gdańsk';
        $sprzedawca->Poczta = 'Gdańsk';

        $jpkfa = new \Jpk\Jpkfa($sprzedawca, "2017-01-01", "2017-01-31", 2206);

        $nabywca = new \Jpk\Podmiot();
        $nabywca->Nazwa = 'Nazwa Klienta 1';
        $nabywca->Ulica = 'Testowa';
        $nabywca->NrDomu = '3';
        $nabywca->KodPocztowy = '12-345';
        $nabywca->Miejscowosc = 'Gdynia';
        $nabywca->Nip = '1234567890';

        $faktura1 = new \Jpk\Faktura($sprzedawca, $nabywca);
        $faktura1->DataWystawienia = '2017-01-01';
        $faktura1->Numer = '123/01/2017 FVS';
        $faktura1->WartoscBrutto = 369;

        $wiersz1 = new \Jpk\Faktura_wiersz();
        $wiersz1->nazwa = 'towar1';
        $wiersz1->cenaJednostkowNetto = 100;
        $faktura1->dodaj_wiersz($wiersz1);

        $wiersz2 = new \Jpk\Faktura_wiersz();
        $wiersz2->nazwa = 'towar 2';
        $wiersz2->cenaJednostkowNetto = 200;
        $wiersz2->ilosc = 3;
        $faktura1->dodaj_wiersz($wiersz2);

        $jpkfa->dodaj_fakture($faktura1);

        $raport = $jpkfa->generuj($raport_path);

        $this->assertFileExists($raport_path);
        $walidator = new \Jpk\Walidator($raport_path);

        $this->assertTrue($walidator->sprawdz_poprawnosc());

        echo $raport;
        echo "\n";
    }

}
