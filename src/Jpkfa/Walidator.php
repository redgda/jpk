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
        return $this->sprawdz_zgodnosc_struktury(__DIR__ .'/../../spec/schemat_jpk_fa.xsd');
    }

    private function sprawdz_zgodnosc_struktury($schema)
    {
        $xml = new \DOMDocument();
        $xml->load($this->plik);
        return $xml->schemaValidate($schema);
    }
}
