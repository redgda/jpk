<?php

class integration_Test extends PHPUnit_Framework_TestCase
{
    function test_one()
    {
        $raport_path = "jpk_fa.xml";

        $podmiot = new \Jpk\Podmiot();
        $podmiot->Nazwa = 'Trojmiasto.pl Sp. z o.o.';
        $podmiot->Nip = 5833012490;
        $podmiot->Regon = 220563678;
        $podmiot->Ulica = 'Wały Piastowskie';
        $podmiot->NrDomu = '1';
        $podmiot->KodPocztowy = '80-855';
        $podmiot->Kod_kraju = 'PL';
        $podmiot->Wojewodztwo = 'POMORSKIE';
        $podmiot->Powiat = 'Gdańsk';
        $podmiot->Miejscowosc = 'Gdańsk';
        $podmiot->Gmina = 'Gdańsk';
        $podmiot->Poczta = 'Gdańsk';

        $jpkfa = new \Jpk\Jpkfa($podmiot, "2017-01-01", "2017-01-31", 2206);

        $klient1 = new \Jpk\Podmiot();
        $klient1->nazwa = 'Nazwa Klienta 1';
        $klient1->adres = 'Testowa 18/5';
        $klient1->kod = '12-345';
        $klient1->miasto = 'Gdynia';

        $faktura1 = new \Jpk\Faktura($podmiot, $klient1);
        $wiersz1 = new \Jpk\Faktura_wiersz("usluga przyklad");
        $wiersz2 = new \Jpk\Faktura_wiersz("produkt przyklad");
        $faktura1->dodaj_wiersz($wiersz1);
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
