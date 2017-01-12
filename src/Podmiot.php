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
}
