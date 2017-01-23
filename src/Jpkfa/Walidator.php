<?php

namespace Jpk;

class Walidator
{
    protected $xsd = '/../../spec/schemat_jpk_fa.xsd';

    public function __construct($plik)
    {
        $this->plik = $plik;
        $this->dom = new \DOMDocument();
        $this->dom->loadXML(file_get_contents($this->plik));
        $this->dx = new \DOMXPath($this->dom);
        $this->dx->registerNamespace("p", 'http://jpk.mf.gov.pl/wzor/2016/03/09/03095/');
    }

    public function sprawdzZgodnoscStruktury($schema = null)
    {
        $schema = $schema ?: __DIR__ . $this->xsd;
        return $this->dom->schemaValidate($schema);
    }

    public function liczbaFakturCtrl()
    {
        return $this->dx->query('//p:FakturaCtrl/p:LiczbaFaktur')->item(0)->nodeValue;
    }

    public function liczbaFaktur()
    {
        return $this->dx->query('//p:Faktura')->length;
    }

    public function liczbaWierszyCtrl()
    {
        return $this->dx->query('//p:FakturaWierszCtrl/p:LiczbaWierszyFaktur')->item(0)->nodeValue;
    }

    public function liczbaWierszy()
    {
        return $this->dx->query('//p:FakturaWiersz')->length;
    }

    public function wartoscFakturCtrl()
    {
        return $this->dx->query('//p:FakturaCtrl/p:WartoscFaktur')->item(0)->nodeValue;
    }

    public function wartoscFaktur()
    {
        $faktury_brutto = $this->dx->query('//p:Faktura/p:P_15');
        $suma_brutto = 0;
        foreach ($faktury_brutto as $brutto)
        {
            $suma_brutto += $brutto->nodeValue;
        }

        return $suma_brutto;
    }

    public function wartoscFakturNetto()
    {
        // kwoty netto sa w roznych polach dla roznych stawek
        $lista_kwot_netto = $this->dx->query(
            '//p:Faktura/p:P_13_1
            | //p:Faktura/p:P_13_2
            | //p:Faktura/p:P_13_3
            | //p:Faktura/p:P_13_4
            | //p:Faktura/p:P_13_5
            | //p:Faktura/p:P_13_6
            | //p:Faktura/p:P_13_7
        ');
        $suma = 0;
        foreach ($lista_kwot_netto as $kwota)
        {
            $suma += $kwota->nodeValue;
        }

        return $suma;
    }

    public function wartoscWierszyCtrl()
    {
        return $this->dx->query('//p:FakturaWierszCtrl/p:WartoscWierszyFaktur')->item(0)->nodeValue;
    }

    public function wartoscWierszyNetto()
    {
        $wiersze_brutto = $this->dx->query('//p:FakturaWiersz/p:P_11');
        $suma_brutto = 0;
        foreach ($wiersze_brutto as $brutto)
        {
            $suma_brutto += $brutto->nodeValue;
        }

        return $suma_brutto;
    }

    // format dat sprawdza xsd
    public function sprawdzDaty()
    {
        $od = $this->dx->query('//p:Naglowek/p:DataOd')->item(0)->nodeValue;
        $do = $this->dx->query('//p:Naglowek/p:DataDo')->item(0)->nodeValue;
        if ($do < $od)
        {
            return false;
        }

        $daty = $this->dx->query('//p:Faktura/p:P_1');
        foreach ($daty as $data)
        {
            if ($data->nodeValue > $do or $data->nodeValue < $od)
            {
                return false;
            }
        }

        return true;
    }

    public function sprawdzNumery()
    {
        $numery = [];
        $numery_dom = $this->dx->query('//p:Faktura/p:P_2A');
        foreach ($numery_dom as $numer)
        {
            if (in_array($numer, $numery))
            {
                return false;
            }
            $numery[] = $numer;
        }
        return true;
    }
}
