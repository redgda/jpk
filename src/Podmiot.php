<?php

namespace Jpk;

class Podmiot
{
    public $nazwa;
    public $nip;
    public $regon;
    public $ulica;
    public $nrDomu;
    public $nrLokalu;
    public $wojewodztwo;
    public $miejscowosc;
    public $gmina;
    public $poczta;
    public $kodPocztowy;
    public $prefixVat;

    public function get_adres()
    {
        $adres = "{$this->kodPocztowy} {$this->miejscowosc}, ";
        $adres .= "{$this->ulica} {$this->nrDomu}";
        if ($this->nrLokalu)
        {
            $adres .= "/{$this->nrLokalu}";
        }

        return trim($adres);
    }

    public function nip()
    {
        return $this->nip;
    }

    public function pelnaNazwa()
    {
        return $this->nazwa;
    }

    public function regon()
    {
        return $this->regon;
    }

    public function wojewodztwo()
    {
        return $this->wojewodztwo;
    }

    public function powiat()
    {
        return $this->powiat;
    }

    public function gmina()
    {
        return $this->gmina;
    }

    public function poczta()
    {
        return $this->poczta;
    }

    public function ulica()
    {
        return $this->ulica;
    }

    public function nrDomu()
    {
        return $this->nrDomu;
    }

    public function nrLokalu()
    {
        return $this->nrLokalu;
    }

    public function miejscowosc()
    {
        return $this->miejscowosc;
    }

    public function kodPocztowy()
    {
        return $this->kodPocztowy;
    }

    public function prefixVat()
    {
        return $this->prefixVat;
    }
}
