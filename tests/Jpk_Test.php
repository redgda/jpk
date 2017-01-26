<?php

class Jpk_Test extends PHPUnit_Framework_TestCase
{
    public function stworz_podmiot($dane=null)
    {
        $sprzedawca = new \Jpk\Podmiot();
        $sprzedawca->nazwa = 'Trojmiasto.pl Sp. z o.o.';
        $sprzedawca->nip = 5833012490;
        $sprzedawca->regon = 220563678;
        $sprzedawca->ulica = 'Wały Piastowskie';
        $sprzedawca->nrDomu = '1';
        $sprzedawca->kodPocztowy = '80-855';
        $sprzedawca->kodKraju = 'PL';
        $sprzedawca->wojewodztwo = 'POMORSKIE';
        $sprzedawca->powiat = 'Gdańsk';
        $sprzedawca->miejscowosc = 'Gdańsk';
        $sprzedawca->gmina = 'Gdańsk';
        $sprzedawca->poczta = 'Gdańsk';

        foreach ((array)$dane as $key=>$value)
        {
            $sprzedawca->$key = $value;
        }

        return $sprzedawca;
    }

    public function stworz_fakture()
    {
        $sprzedawca = $this->stworz_podmiot();
        $nabywca = $this->stworz_podmiot([
            'nazwa'=>'Klient 1',
            'nip'=>'1234567890',
            'ulica' => 'Testowa',
            'nrDomu' => 3
        ]);
        $faktura = new \Jpk\Faktura($sprzedawca, $nabywca);

        return $faktura;
    }

    public function assertXSDValid($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertTrue(
            $walidator->sprawdzZgodnoscStruktury(),
            'niezgodny z formalna struktura xsd'
        );
    }

}
