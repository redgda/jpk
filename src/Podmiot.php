<?php

namespace Jpk;

class Podmiot
{
    public $Nazwa;
    public $Nip;
    public $Regon;
    public $Ulica;
    public $NrDomu;
    public $NrLokalu;
    public $Wojewodztwo;
    public $Miejscowosc;
    public $Gmina;
    public $Poczta;
    public $KodPocztowy;
    public $prefixVat;

    public function get_adres()
    {
        $adres = "{$this->KodPocztowy} {$this->Miejscowosc}, ";
        $adres .= "{$this->Ulica} {$this->NrDomu}";
        if ($this->NrLokalu)
        {
            $adres .= "/{$this->NrLokalu}";
        }

        return trim($adres);
    }

    public function nip()
    {
        return $this->Nip;
    }

    public function pelnaNazwa()
    {
        return $this->Nazwa;
    }

    public function regon()
    {
        return $this->Regon;
    }

    public function wojewodztwo()
    {
        return $this->Wojewodztwo;
    }

    public function powiat()
    {
        return $this->Powiat;
    }

    public function gmina()
    {
        return $this->Gmina;
    }

    public function poczta()
    {
        return $this->Poczta;
    }

    public function ulica()
    {
        return $this->Ulica;
    }

    public function nrDomu()
    {
        return $this->NrDomu;
    }

    public function nrLokalu()
    {
        return $this->NrLokalu;
    }

    public function miejscowosc()
    {
        return $this->Miejscowosc;
    }

    public function kodPocztowy()
    {
        return $this->KodPocztowy;
    }
}
