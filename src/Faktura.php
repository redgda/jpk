<?php

namespace Jpk;

class Faktura
{
    public $DataWystawienia;
    public $DataWykonania;
    public $Numer;

    public function __construct($podmiot, $klient)
    {
        $this->sprzedawca = $podmiot;
        $this->nabywca = $klient;
    }

    public function dodaj_wiersz($wiersz)
    {
        $this->wiersze[] = $wiersz;
    }

    public function suma($typ='netto', $tylko_okreslona_stawka=false)
    {
        return 321; //@todo
    }

    public function dataWykonania()
    {
        return $this->DataWykonania ?: $this->DataWystawienia; //@todo czy napewno?
    }

    public function dataWystawienia()
    {
        return $this->DataWystawienia;
    }

    public function numer()
    {
        return $this->Numer;
    }

    public function nazwaNabywcy()
    {
        return $this->nabywca->Nazwa;
    }

    public function adresNabywcy()
    {
        return $this->nabywca->get_adres();
    }

    public function nazwaSprzedawcy()
    {
        return $this->sprzedawca->Nazwa;
    }

    public function adresSprzedawcy()
    {
        return $this->sprzedawca->get_adres();
    }

    public function prefixVatSprzedawca()
    {
        return $this->sprzedawca->prefixVat ?: 'PL';
    }

    public function prefixVatNabywca()
    {
        return $this->nabywca->prefixVat ?: 'PL';
    }

    public function nipSprzedawca()
    {
        return $this->sprzedawca->Nip;
    }

    public function nipNabywca()
    {
        return $this->nabywca->Nip;
    }

    public function rodzaj()
    {
        return 'VAT';
    }
}
