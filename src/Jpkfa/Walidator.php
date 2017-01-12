<?php

namespace Jpk;

class Walidator
{
    public function __construct($plik)
    {
        $this->plik = $plik;
    }

    public function sprawdz_poprawnosc()
    {
        return $this->sprawdz_zgodnosc_struktury();
    }

    public function sprawdz_zgodnosc_struktury($schema_file)
    {
        $xml = new \DOMDocument();
        $xml->load($this->plik);
        return $xml->schemaValidate($schema_file);
    }

    // czy zgadzaja sie sumy kwot i ilosciowe
    public function sprawdz_zgodnosc_logiczna()
    {
        //@todo
    }
}
