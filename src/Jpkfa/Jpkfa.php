<?php

namespace Jpk;

class Jpkfa
{

    public function __construct($podmiot1, $data_od, $data_do, $kod_urzedu, $cel_zlozenia=1)
    {
        $this->dane['Podmiot1'] = $podmiot1;
        $this->dane['DataOd'] = $data_od;
        $this->dane['DataDo'] = $data_do;
        $this->dane['KodUrzedu'] = $kod_urzedu;
        $this->dane['CelZlozenia'] = $cel_zlozenia;

        $this->dane['DomyslnyKodWaluty'] = 'PLN';
        $this->dane['DataWytworzeniaJPK'] = date("Y-m-d\TH:i:s");

        $this->dane['FakturaCtrl']['LiczbaFaktur'] = 0;
        $this->dane['FakturaCtrl']['WartoscFaktur'] = 0;

        $this->set_generator();
    }

    public function set_generator($generator = null)
    {
        if (!$generator)
        {
            $generator = new \Jpk\Generator_smarty;
        }

        $this->generator = $generator;
    }

    public function dodaj_fakture($faktura)
    {
        $this->dane['faktury'][] = self::przetworz_dane($faktura);
        $this->dane['FakturaCtrl']['LiczbaFaktur'] ++;
        $this->dane['FakturaCtrl']['WartoscFaktur'] += $faktura->suma('brutto');
    }

    public function generuj($path)
    {
        file_put_contents($path, $this->generator->xml($this->dane));
    }

    protected function przetworz_dane($faktura)
    {
        $dane['Typ'] = 'G'; // jedyna dozwolona wartosc

        $dane['P_1'] = $faktura->dataWystawienia();
        $dane['P_2A'] = $faktura->numer();

        $dane['P_3A'] = $faktura->nazwaNabywcy();
        $dane['P_3B'] = $faktura->adresNabywcy();

        $dane['P_3C'] = $faktura->nazwaSprzedawcy();
        $dane['P_3D'] = $faktura->adresSprzedawcy();

        $dane['P_4A'] = $faktura->prefixVatSprzedawca();
        $dane['P_4B'] = $faktura->nipSprzedawca();

        $dane['P_5A'] = $faktura->prefixVatNabywca();
        $dane['P_5B'] = $faktura->nipNabywca();

        $dane['P_6'] = $faktura->dataWykonania();

        $dane['P_13_1'] = $faktura->suma('netto', 23);
        $dane['P_14_1'] = $faktura->suma('netto', 23);
        $dane['P_15'] = $faktura->suma('brutto');

        $dane['RodzajFaktury'] = $faktura->rodzaj();

        $dane['P_16'] = false;
        $dane['P_17'] = false;
        $dane['P_18'] = false;
        $dane['P_19'] = false;
        $dane['P_20'] = false;
        $dane['P_21'] = false;
        $dane['P_23'] = false;
        $dane['P_106E_2'] = false;
        $dane['P_106E_3'] = false;

        return $dane;
    }
}
