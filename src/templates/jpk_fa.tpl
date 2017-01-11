<?xml version="1.0" encoding="utf-8"?>
<JPK xmlns="http://jpk.mf.gov.pl/wzor/2016/03/09/03095/" xmlns:etd="http://crd.gov.pl/xml/schematy/dziedzinowe/mf/2016/01/25/eD/DefinicjeTypy/">
      <Naglowek>
            <KodFormularza kodSystemowy="JPK_FA (1)" wersjaSchemy="1-0">JPK_FA</KodFormularza>
            <WariantFormularza>1</WariantFormularza>
            <CelZlozenia>{$dane.CelZlozenia}</CelZlozenia>
            <DataWytworzeniaJPK>{$dane.DataWytworzeniaJPK}</DataWytworzeniaJPK>
            <DataOd>{$dane.DataOd}</DataOd>
            <DataDo>{$dane.DataDo}</DataDo>
            <DomyslnyKodWaluty>{$dane.DomyslnyKodWaluty}</DomyslnyKodWaluty>
            <KodUrzedu>{$dane.KodUrzedu}</KodUrzedu>
      </Naglowek>
      <Podmiot1>
         <IdentyfikatorPodmiotu>
            <etd:NIP>{$Podmiot1->Nip}</etd:NIP>
            <etd:PelnaNazwa>{$Podmiot1->Nazwa}</etd:PelnaNazwa>
            <etd:REGON>{$Podmiot1->Regon}</etd:REGON>
         </IdentyfikatorPodmiotu>
         <AdresPodmiotu>
            <etd:KodKraju>{$Podmiot1->Kod_kraju}</etd:KodKraju>
            <etd:Wojewodztwo>{$Podmiot1->Wojewodztwo}</etd:Wojewodztwo>
            <etd:Powiat>{$Podmiot1->Powiat}</etd:Powiat>
            <etd:Gmina>{$Podmiot1->Gmina}</etd:Gmina>
            <etd:Ulica>{$Podmiot1->Ulica}</etd:Ulica>
            <etd:NrDomu>{$Podmiot1->NrDomu}</etd:NrDomu>
            {if $Podmiot1->NrLokalu}<etd:NrLokalu>{$Podmiot1->NrLokalu}</etd:NrLokalu>{/if}
            <etd:Miejscowosc>{$Podmiot1->Miejscowosc}</etd:Miejscowosc>
            <etd:KodPocztowy>{$Podmiot1->KodPocztowy}</etd:KodPocztowy>
            <etd:Poczta>{$Podmiot1->Poczta}</etd:Poczta>
         </AdresPodmiotu>
      </Podmiot1>
      <Faktura typ="G">
            <P_1>2016-07-01</P_1>
            <P_2A>1</P_2A>
            <P_3A>TEST NABYWCA SP. Z O.O.</P_3A>
            <P_3B>01-001 WARSZAWA, PLAC BANKOWY 1</P_3B>
            <P_3C>TEST SPRZEDAWCA S.C.</P_3C>
            <P_3D>03-133 WARSZAWA, PROSTA 1</P_3D>
            <P_4B>1111111111</P_4B>
            <P_6>2016-05-24</P_6>
            <P_13_1>1.00</P_13_1>
            <P_14_1>0.23</P_14_1>
            <P_15>1.23</P_15>
            <P_16>false</P_16>
            <P_17>false</P_17>
            <P_18>false</P_18>
            <P_19>false</P_19>
            <P_20>false</P_20>
            <P_21>false</P_21>
            <P_23>false</P_23>
            <P_106E_2>false</P_106E_2>
            <P_106E_3>false</P_106E_3>
            <RodzajFaktury>POZ</RodzajFaktury>
      </Faktura>
      <FakturaCtrl>
            <LiczbaFaktur>1</LiczbaFaktur>
            <WartoscFaktur>1.23</WartoscFaktur>
      </FakturaCtrl>
      <StawkiPodatku>
            <Stawka1>0.23</Stawka1>
            <Stawka2>0.08</Stawka2>
            <Stawka3>0.05</Stawka3>
            <Stawka4>0.00</Stawka4>
            <Stawka5>0.00</Stawka5>
      </StawkiPodatku>
      <FakturaWiersz typ="G">
            <P_2B>1</P_2B>
            <P_7>TESTOWY PRZEDMIOT SPRZEDAŻY1</P_7>
            <P_8A>SZT</P_8A>
            <P_8B>1</P_8B>
            <P_9A>1.00</P_9A>
            <P_9B>1.23</P_9B>
            <P_11>1.00</P_11>
            <P_11A>1.23</P_11A>
            <P_12>0</P_12>
      </FakturaWiersz>
      <FakturaWierszCtrl>
            <LiczbaWierszyFaktur>1</LiczbaWierszyFaktur>
            <WartoscWierszyFaktur>1.23</WartoscWierszyFaktur>
      </FakturaWierszCtrl>
</JPK>
