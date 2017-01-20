<?php

namespace Jpk;

class Faktura
{
    public $dataWystawienia;
    public $dataWykonania;
    public $numer;
    public $przyczynaKorekty = '';
    public $numerFakturyKorygowanej = '';
    public $okresFakturyKorygowanej = '';

    protected $sumy;
    protected $stawki = array(0, 5, 8, 23);

    public function __construct($podmiot, $klient)
    {
        $this->sprzedawca = $podmiot;
        $this->nabywca = $klient;
        $this->zerujSumy();
    }

    protected function zerujSumy()
    {
        foreach (array_merge($this->stawki, ['total', 'zw']) as $indeks)
        {
            $this->sumy['netto'][$indeks] = 0;
            $this->sumy['brutto'][$indeks] = 0;
            $this->sumy['podatek'][$indeks] = 0;
        }
    }

    public function przelicz()
    {
        $this->zerujSumy();

        foreach ($this->wiersze as $wiersz)
        {
            $suma_wiersza_netto = $wiersz->sumaNetto();
            $suma_wiersza_podatek = $wiersz->sumaPodatek();
            $suma_wiersza_brutto = $wiersz->sumaBrutto();

            $indeks = $wiersz->stawkaVatOpis();

            $this->sumy['netto'][$indeks] += $suma_wiersza_netto;
            $this->sumy['podatek'][$indeks] += $suma_wiersza_podatek;
            $this->sumy['brutto'][$indeks] += $suma_wiersza_brutto;

            $this->sumy['netto']['total'] += $suma_wiersza_netto;
            $this->sumy['podatek']['total'] += $suma_wiersza_podatek;
            $this->sumy['brutto']['total'] += $suma_wiersza_brutto;
        }
    }

    public function dodajWiersz(FakturaWiersz $wiersz)
    {
        $this->wiersze[] = clone $wiersz;
        $this->przelicz();
    }

    public function usunWiersze()
    {
        $this->wiersze = [];
        $this->przelicz();
    }

    public function korygujWiersz(FakturaWiersz $wiersz)
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
        return $this->dataWykonania ?: false;
    }

    public function dataWystawienia()
    {
        return $this->dataWystawienia;
    }

    public function numer()
    {
        return $this->numer;
    }

    public function nazwaNabywcy()
    {
        return $this->nabywca->pelnaNazwa();
    }

    public function adresNabywcy()
    {
        return $this->nabywca->get_adres();
    }

    public function nazwaSprzedawcy()
    {
        return $this->sprzedawca->pelnaNazwa();
    }

    public function adresSprzedawcy()
    {
        return $this->sprzedawca->get_adres();
    }

    public function prefixVatSprzedawca()
    {
        return $this->sprzedawca->prefixVat() ?: 'PL';
    }

    public function prefixVatNabywca()
    {
        return $this->nabywca->prefixVat() ?: 'PL';
    }

    public function nipSprzedawca()
    {
        return $this->sprzedawca->nip();
    }

    public function nipNabywca()
    {
        return $this->nabywca->nip();
    }

    public function rodzaj()
    {
        if ($this->numerFakturyKorygowanej)
        {
            return 'KOREKTA';
        }

        return 'VAT';
    }

    public function wiersze()
    {
        return $this->wiersze;
    }

    public function przyczynaKorekty()
    {
        return $this->przyczynaKorekty;
    }

    public function numerFakturyKorygowanej()
    {
        return $this->numerFakturyKorygowanej;
    }

    public function okresFakturyKorygowanej()
    {
        return $this->okresFakturyKorygowanej;
    }
}
