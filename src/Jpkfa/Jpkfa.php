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
    }

    public function generuj($path)
    {
        file_put_contents($path, $this->generator->xml($this->dane));
    }
}
