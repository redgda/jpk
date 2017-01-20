<?php

namespace Jpk;

class FakturaWiersz
{
    public $nazwa;
    public $cenaJednostkowaNetto;
    public $miara = 'szt';
    public $ilosc = 1;
    public $stawkaVat = 23;

    // zwolnione i 0 maja wartosc stawki 0 ale opis bedzie inny "zw" lub 0
    public $stawkaVatOpis;

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

    public function sumaNetto()
    {
        return $this->cenaJednostkowaNetto * $this->ilosc;
    }

    public function sumaBrutto()
    {
        return $this->sumaNetto() + $this->sumaPodatek();
    }

    public function sumaPodatek()
    {
        return round(($this->sumaNetto() * $this->stawkaVat/100), 2);
    }

    public function stawkaVat()
    {
        return $this->stawkaVat;
    }

    public function stawkaVatOpis()
    {
        if ($this->stawkaVatOpis)
        {
            // mozliwosc ustawienia 'zw'
            return $this->stawkaVatOpis;
        }
        else
        {
            return $this->stawkaVat;
        }
    }
}
