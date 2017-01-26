<?php

class korekta_Test extends Jpk_Test
{
    function test_generuj()
    {
        $raport_path = "raport3.xml";

        $faktura = $this->stworz_fakture();
        $faktura->dataWystawienia = '2017-01-01';
        $faktura->numer = '1/17/FKS';
        $faktura->numerFakturyKorygowanej = '01/01/2016 FVS';
        $faktura->przyczynaKorekty = 'Rezygnacja';
        $faktura->okresFakturyKorygowanej = '2016-01-01';

        // sposob reprezentowania wierszy korekty w JPKFA nie jest zdefiniowany
        // zakladam rozne warianty:
        // a) wiersz pierwotny, wiersz korygujacy, wiersz po korekcie (bilans wierszy zerowy)
        // b) tylko wiersz korygujacy, wtedy faktura bedzie miala (bilans wierszy ujemny)
        // c) tylko wiersz po korekcie (bilans wierszy wg stanu po korekcie)

        // narazie wg mojego rozpoznania najbardizej prawdopodobny jest wariant c)
        $wiersz1 = new \Jpk\FakturaWiersz();
        $wiersz1->nazwa = 'towar1';
        $wiersz1->cenaJednostkowaNetto = 100;
        $wiersz1->ilosc = 0; // nowa ilosc
        $faktura->dodajWiersz($wiersz1);

        $jpkfa = new \Jpk\Jpkfa($faktura->sprzedawca, "2017-01-01", "2017-01-31", 2206);
        $jpkfa->dodajFakture($faktura);
        $jpkfa->generuj($raport_path);
        $this->assertFileExists($raport_path);

        return $raport_path;
    }

    /**
     * @depends test_generuj
     */
    function test_struktury($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertTrue(
            $walidator->sprawdzZgodnoscStruktury(),
            'niezgodny z formalna struktura xsd'
        );
    }

    /**
     * @depends test_generuj
     */
    function test_wartosc_faktur($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertEquals(0, $walidator->wartoscFaktur()); // P_15
        $this->assertEquals(0, $walidator->wartoscFakturCtrl()); // faktury ctrl
        $this->assertEquals(0, $walidator->wartoscFakturNetto()); // P_13_1
    }

    /**
     * @depends test_generuj
     */
    function test_wartosc_wierszy($raport_path)
    {
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertEquals(0, $walidator->wartoscWierszyNetto());
        $this->assertEquals(0, $walidator->wartoscWierszyCtrl());
    }

    /**
     * @depends test_generuj
     */
    function test_pola_korekty($raport_path)
    {
        $xpath = '//p:Faktura[1]//p:RodzajFaktury';
        $walidator = new \Jpk\Walidator($raport_path);
        $this->assertEquals(
            'KOREKTA',
            $walidator->dx->query($xpath)->item(0)->nodeValue,
            $xpath
        );

        $xpath = '//p:Faktura[1]//p:PrzyczynaKorekty';
        $this->assertNotEmpty(
            strlen($walidator->dx->query($xpath)->item(0)->nodeValue),
            $xpath
        );

        $xpath = '//p:Faktura[1]//p:NrFaKorygowanej';
        $this->assertNotEmpty(
            strlen($walidator->dx->query($xpath)->item(0)->nodeValue),
            $xpath
        );

        $xpath = '//p:Faktura[1]//p:OkresFaKorygowanej';
        $this->assertNotEmpty(
            strlen($walidator->dx->query($xpath)->item(0)->nodeValue),
            $xpath
        );
    }
}
