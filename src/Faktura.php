<?php

namespace Jpk;

class Faktura
{
    public function __construct($podmiot, $klient)
    {
        $this->podmiot = $podmiot;
        $this->klient = $klient;
    }

    public function dodaj_wiersz($pozycja)
    {
        $this->wiersze[] = $pozycja;
    }

}
