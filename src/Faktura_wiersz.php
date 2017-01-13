<?php

namespace Jpk;

class Faktura_wiersz
{
    public $nazwa;
    public $cenaJednostkowNetto;
    public $miara = 'szt';
    public $ilosc = 1;
    public $stawkaVat = 23;

    // zwolnione i 0 maja wartosc stawki 0 ale opis bedzie inny "zw" lub 0
    public $stawkaVatOpis = 23;
}
