<?php

namespace Jpk;

class Faktura
{
    public $DataWystawienia;
    public $DataWykonania;
    public $Numer;

    protected $sumy;
    protected $stawki = array(0, 5, 8, 23);

    public function __construct($podmiot, $klient)
    {
        $this->sprzedawca = $podmiot;
        $this->nabywca = $klient;
        $this->zeruj_sumy();
    }

    protected function zeruj_sumy()
    {
        foreach (array_merge($this->stawki, ['total']) as $indeks)
        {
            $this->sumy['netto'][$indeks] = 0;
            $this->sumy['brutto'][$indeks] = 0;
            $this->sumy['podatek'][$indeks] = 0;
        }
    }

    public function przelicz()
    {
        $this->zeruj_sumy();

        foreach ($this->wiersze as $wiersz)
        {
            $suma_wiersza_netto = $wiersz->cenaJednostkowaNetto * $wiersz->ilosc;
            $suma_wiersza_podatek = round($suma_wiersza_netto * $wiersz->stawkaVat/100, 2);
            $suma_wiersza_brutto = $suma_wiersza_netto + $suma_wiersza_podatek;

            // @todo problem ze stawkami zw. i 0
            $indeks = $wiersz->stawkaVat;

            $this->sumy['netto'][$indeks] += $suma_wiersza_netto;
            $this->sumy['podatek'][$indeks] += $suma_wiersza_podatek;
            $this->sumy['brutto'][$indeks] += $suma_wiersza_brutto;

            $this->sumy['netto']['total'] += $suma_wiersza_netto;
            $this->sumy['podatek']['total'] += $suma_wiersza_podatek;
            $this->sumy['brutto']['total'] += $suma_wiersza_brutto;
        }
    }

    public function dodaj_wiersz($wiersz)
    {
        $this->wiersze[] = $wiersz;
        $this->przelicz();
    }

    public function suma($typ='netto', $stawka_vat='total')
    {
        $this->przelicz();
        return $this->sumy[$typ][$stawka_vat];
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

    public function wiersze()
    {
        return $this->wiersze;
    }
}
