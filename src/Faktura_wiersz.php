<?php

namespace Jpk;

class Faktura_wiersz
{
    public $nazwa;
    public $cenaJednostkowaNetto;
    public $miara = 'szt';
    public $ilosc = 1;
    public $stawkaVat = 23;

    // zwolnione i 0 maja wartosc stawki 0 ale opis bedzie inny "zw" lub 0
    public $stawkaVatOpis = 23;

    public function nazwa()
    {
        return $this->nazwa;
    }

    public function miara()
    {
        return $this->miara;
    }

    public function ilosc()
    {
        return $this->ilosc;
    }

    public function cenaJednostkowaNetto()
    {
        return $this->cenaJednostkowaNetto;
    }

    public function cenaJednostkowaBrutto()
    {
        return round($this->sumaBrutto() / $this->ilosc, 2);
    }

    public function sumaNetto()
    {
        return $this->cenaJednostkowaNetto * $this->ilosc;
    }

    public function sumaBrutto()
    {
        return round($this->sumaNetto() * (1 + $this->stawkaVat/100), 2);
    }

    public function stawkaVat()
    {
        return $this->stawkaVat;
    }

    public function stawkaVatOpis()
    {
        // todo ustalic
        return $this->stawkaVat;
    }
}
