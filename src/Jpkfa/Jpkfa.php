<?php

namespace Jpk;

class Jpkfa
{
    public function __construct($podmiot, $data_od, $data_do)
    {
        $this->podmiot = $podmiot;
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
        file_put_contents($path, $this->generator->xml());
    }
}
