<?php

namespace Jpk;

class Walidator
{
    protected $xsd = '/../../spec/schemat_jpk_fa.xsd';
    protected $bledy = [];

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
        libxml_use_internal_errors(true);
        $schema = $schema ?: __DIR__ . $this->xsd;
        $ret = $this->dom->schemaValidate($schema);
        $errors = (array)libxml_get_errors();
        foreach ($errors as $e)
        {
            $this->bledy[] = $e->message;
        }
        libxml_clear_errors();
        libxml_use_internal_errors(false);

        return $ret;
    }

    /**
     * dodatkowa weryfikacja wygenerowanego raportu
     */
    public function sprawdzPoprawnoscDanych()
    {
        $this->sprawdzDaty();
        $this->unikalnoscNumerowFaktur();
        $this->kazdyNumerFakturyMaWiersz();
        $this->kazdyNumerWierszaMaFakture();
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
        $ret = true;
        $od = $this->dx->query('//p:Naglowek/p:DataOd')->item(0)->nodeValue;
        $do = $this->dx->query('//p:Naglowek/p:DataDo')->item(0)->nodeValue;
        if ($do < $od)
        {
            $this->bledy[] = "niepoprawny zakres dat (od:$od, do:$do)";
            $ret = false;
        }

        $daty = $this->dx->query('//p:Faktura/p:P_1');
        foreach ($daty as $data)
        {
            if ($data->nodeValue > $do or $data->nodeValue < $od)
            {
                $this->bledy[] = "data dokumentu poza zdefiniowanym zakresem ($od, $do)";
                $ret = false;
            }

            if ($ostatnia_data && $ostatnia_data>$data->nodeValue)
            {
                $this->bledy[] = "dokumenty nie sa posortowane chronologicznie ($data->nodeValue)";
                $ret = false;
            }

            $ostatnia_data = $data->nodeValue;
        }

        return $ret;
    }

    protected function numeryFaktur()
    {
        $list = $this->dx->query('//p:Faktura/p:P_2A');
        foreach ($list as $i)
        {
            $ret[] = $i->nodeValue;
        }
        return (array)$ret;
    }

    protected function numeryWierszy()
    {
        $list = $this->dx->query('//p:FakturaWiersz/p:P_2B');
        foreach ($list as $i)
        {
            $ret[] = $i->nodeValue;
        }
        return (array)$ret;
    }

    public function unikalnoscNumerowFaktur()
    {
        $ret = true;
        $numery = $this->numeryFaktur();
        $wystapienia = array_count_values($numery);
        foreach ($wystapienia as $numer=>$licznik)
        {
            if ($licznik > 1)
            {
                $this->bledy[] = "numer $numer wystepuje wiecej niz raz ($licznik)";
                $ret = false;
            }
        }

        return $ret;
    }

    public function kazdyNumerFakturyMaWiersz()
    {
        $ret = true;
        $numery_faktur = $this->numeryFaktur();
        $numery_wierszy = $this->numeryWierszy();

        foreach ($numery_faktur as $numer)
        {
            if (!in_array($numer, $numery_wierszy))
            {
                $this->bledy[] = "faktura $numer nie ma odpowiednika w wierszach";
                $ret = false;
            }
        }

        return $ret;
    }

    public function kazdyNumerWierszaMaFakture()
    {
        $ret = true;
        $numery_faktur = $this->numeryFaktur();
        $numery_wierszy = $this->numeryWierszy();

        foreach ($numery_wierszy as $numer)
        {
            if (!in_array($numer, $numery_faktur))
            {
                $this->bledy[] = "faktura $numer nie ma odpowiednika w wierszach";
                $ret = false;
            }
        }

        return $ret;
    }

    public function bledy()
    {
        return $this->bledy;
    }
}
