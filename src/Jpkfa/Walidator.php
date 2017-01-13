<?php

namespace Jpk;

class Walidator
{
    public function __construct($plik)
    {
        $this->plik = $plik;
        $this->file_contents = file_get_contents($this->plik);

        $this->dom = new \DOMDocument();
        $this->dom->loadXML($this->file_contents);
        $this->dx = new \DOMXPath($this->dom);
        $this->dx->registerNamespace("p", 'http://jpk.mf.gov.pl/wzor/2016/03/09/03095/');
    }

    public function sprawdz_poprawnosc()
    {
        return $this->sprawdz_zgodnosc_struktury();
    }

    public function sprawdz_zgodnosc_struktury($schema_file)
    {
        return $this->dom->schemaValidate($schema_file);
    }

    public function sprawdz_liczbe_faktur()
    {
        $faktury = $this->dx->query('//p:Faktura');
        $liczba_faktur_ctrl = $this->dx->query('//p:FakturaCtrl/p:LiczbaFaktur')->item(0)->nodeValue;
        return $faktury->length == $liczba_faktur_ctrl;
    }

    public function sprawdz_wartosc_faktur()
    {
        $faktury = $this->dx->query('//p:Faktura');
        $wartosc_faktur_ctrl = $this->dx->query('//p:FakturaCtrl/p:WartoscFaktur')->item(0)->nodeValue;

        $suma_brutto = 0;
        foreach ($faktury as $faktura)
        {
            $suma_brutto += $this->dx->query('//p:P_15', $faktura)->item(0)->nodeValue;
        }

        return $suma_brutto == $wartosc_faktur_ctrl;
    }
}
