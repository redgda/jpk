<?php

class Jpk_Test extends PHPUnit_Framework_TestCase
{
    public function stworz_podmiot($dane=null)
    {
        $sprzedawca = new \Jpk\Podmiot();
        $sprzedawca->Nazwa = 'Trojmiasto.pl Sp. z o.o.';
        $sprzedawca->Nip = 5833012490;
        $sprzedawca->Regon = 220563678;
        $sprzedawca->Ulica = 'Wały Piastowskie';
        $sprzedawca->NrDomu = '1';
        $sprzedawca->KodPocztowy = '80-855';
        $sprzedawca->KodKraju = 'PL';
        $sprzedawca->Wojewodztwo = 'POMORSKIE';
        $sprzedawca->Powiat = 'Gdańsk';
        $sprzedawca->Miejscowosc = 'Gdańsk';
        $sprzedawca->Gmina = 'Gdańsk';
        $sprzedawca->Poczta = 'Gdańsk';

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
            'Nazwa'=>'Klient 1',
            'Nip'=>'1234567890',
            'Ulica' => 'Testowa',
            'NrDomu' => 3
        ]);
        $faktura = new \Jpk\Faktura($sprzedawca, $nabywca);

        return $faktura;
    }

}
