<?php

namespace Jpk;

class Jpkfa
{

    public function __construct($podmiot1, $data_od, $data_do, $kod_urzedu, $cel_zlozenia=1)
    {
        $this->dane['xmlns'] = 'http://jpk.mf.gov.pl/wzor/2016/03/09/03095/';
        $this->dane['xmlns_etd'] = 'http://crd.gov.pl/xml/schematy/dziedzinowe/mf/2016/01/25/eD/DefinicjeTypy/';

        $naglowek['KodFormularza'] = 'JPK_FA';
        $naglowek['kodSystemowy'] = 'JPK_FA (1)';
        $naglowek['wersjaSchemy'] = '1-0';
        $naglowek['WariantFormularza'] = '1';
        $naglowek['CelZlozenia'] = $cel_zlozenia;
        $naglowek['DataOd'] = $data_od;
        $naglowek['DataDo'] = $data_do;
        $naglowek['DomyslnyKodWaluty'] = 'PLN';
        $naglowek['DataWytworzeniaJPK'] = date("Y-m-d\TH:i:s");
        $naglowek['KodUrzedu'] = $kod_urzedu;
        $this->dane['Naglowek'] = $naglowek;

        $this->dane['Podmiot1'] = self::mapujPodmiot($podmiot1);

        $this->dane['Faktury'] = [];
        $this->dane['Wiersze'] = [];

        $this->dane['FakturaCtrl']['LiczbaFaktur'] = 0;
        $this->dane['FakturaCtrl']['WartoscFaktur'] = 0;

        $this->dane['FakturaWierszCtrl']['LiczbaWierszyFaktur'] = 0;
        $this->dane['FakturaWierszCtrl']['WartoscWierszyFaktur'] = 0;

        $this->setGenerator();
    }

    public function setGenerator(XMLGenerator $generator = null)
    {
        if (!$generator)
        {
            $smarty = new \Smarty;
            $generator = new \Jpk\GeneratorSmarty($smarty);
        }

        $this->generator = $generator;
    }

    public function dodajFakture(Faktura $faktura)
    {
        $this->dane['Faktury'][] = self::mapujFakture($faktura);
        $this->dane['FakturaCtrl']['LiczbaFaktur']++;
        $this->dane['FakturaCtrl']['WartoscFaktur'] += $faktura->suma('netto');

        foreach ($faktura->wiersze as $wiersz)
        {
            $faktura_numer = $faktura->numer();
            $this->dane['Wiersze'][] = self::mapujWiersz($wiersz, $faktura_numer);
            $this->dane['FakturaWierszCtrl']['LiczbaWierszyFaktur']++;
            $this->dane['FakturaWierszCtrl']['WartoscWierszyFaktur'] += $wiersz->sumaNetto();
        }
    }

    public function generuj($path)
    {
        if (count($this->dane['Faktury']) == 0)
        {
            // w aktualnym schemacie nie mozna wygenerowac raportu bez elementu Faktura
            return false;
        }

        return file_put_contents($path, $this->generator->xml($this->dane));
    }

    protected function mapujFakture($faktura)
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
        $dane['P_6'] = $faktura->dataWykonania(); // opcjonalne

        $dane['P_13_1'] = $faktura->suma('netto', 23);
        $dane['P_14_1'] = $faktura->suma('podatek', 23);
        $dane['P_13_2'] = $faktura->suma('netto', 8);
        $dane['P_14_2'] = $faktura->suma('podatek', 8);
        $dane['P_13_3'] = $faktura->suma('netto', 5);
        $dane['P_14_3'] = $faktura->suma('podatek', 5);
        $dane['P_13_4'] = null; //pole rezerwowe
        $dane['P_13_5'] = null; //pole rezerwowe
        $dane['P_13_5'] = null; //pole rezerwowe
        $dane['P_13_6'] = $faktura->suma('netto', 0);
        $dane['P_13_7'] = $faktura->suma('netto', 'zw');

        // pyt.43
        // http://www.mf.gov.pl/documents/764034/5134536/Odpowiedzi+na+pytania+dot.+JPK.pdf
        $dane['P_15'] = $faktura->suma('brutto');

        $dane['RodzajFaktury'] = $faktura->rodzaj();
        $dane['PrzyczynaKorekty'] = $faktura->przyczynaKorekty();
        $dane['NrFaKorygowanej'] = $faktura->numerFakturyKorygowanej();
        // wymagane przez xsd, czy to jest data faktury korygowanej?
        $dane['OkresFaKorygowanej'] = $faktura->okresFakturyKorygowanej();

        $dane['P_16'] = 'false'; //metoda kasowa
        $dane['P_17'] = 'false'; // samofakturowanie
        $dane['P_18'] = 'false'; // odwrotne obciazenie
        $dane['P_19'] = 'false'; // zwolnione z podatku
        $dane['P_20'] = 'false';
        $dane['P_21'] = 'false';
        $dane['P_23'] = 'false';
        $dane['P_106E_2'] = 'false';
        $dane['P_106E_3'] = 'false';

        return $dane;
    }

    protected function mapujWiersz(FakturaWiersz $wiersz, $numer_faktury)
    {
        $dane['Typ'] = 'G'; // stala wartosc

        $dane['P2_b'] = $numer_faktury;
        $dane['P_7'] = $wiersz->nazwa();
        $dane['P_8A'] = $wiersz->miara();
        $dane['P_8B'] = $wiersz->ilosc();
        $dane['P_9A'] = $wiersz->cenaJednostkowaNetto();
        $dane['P_11'] = $wiersz->sumaNetto();
        $dane['P_9B'] = false; // ceny jedn. brutto nie wspierane
        $dane['P_11A'] = false; // ceny jedn. brutto nie wspierane
        $dane['P_12'] = $wiersz->stawkaVatOpis();

        return $dane;
    }

    protected function mapujPodmiot(Podmiot $podmiot)
    {
        $dane['KodKraju'] = 'PL'; // stala wartosc

        $dane['NIP'] = $podmiot->nip();
        $dane['PelnaNazwa'] = $podmiot->pelnaNazwa();
        $dane['Regon'] = $podmiot->regon();
        $dane['Wojewodztwo'] = $podmiot->wojewodztwo();
        $dane['Powiat'] = $podmiot->powiat();
        $dane['Gmina'] = $podmiot->gmina();
        $dane['Poczta'] = $podmiot->poczta();
        $dane['Ulica'] = $podmiot->ulica();
        $dane['NrDomu'] = $podmiot->nrDomu();
        $dane['NrLokalu'] = $podmiot->nrLokalu();
        $dane['Miejscowosc'] = $podmiot->miejscowosc();
        $dane['KodPocztowy'] = $podmiot->kodPocztowy();
        $dane['Poczta'] = $podmiot->poczta();

        return $dane;
    }
}
