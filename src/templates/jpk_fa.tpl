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

      {foreach from=$Faktury item=faktura}
      <Faktura typ="{$faktura.Typ}">
            <P_1>{$faktura.P_1}</P_1>
            <P_2A>{$faktura.P_2A}</P_2A>
            <P_3A>{$faktura.P_3A}</P_3A>
            <P_3B>{$faktura.P_3B}</P_3B>
            <P_3C>{$faktura.P_3C}</P_3C>
            <P_3D>{$faktura.P_3D}</P_3D>
            <P_4B>{$faktura.P_4B}</P_4B>
            <P_6>{$faktura.P_6}</P_6>
            <P_13_1>{$faktura.P_13_1}</P_13_1>
            <P_14_1>{$faktura.P_14_1}</P_14_1>
            <P_15>{$faktura.P_15}</P_15>
            <P_16>{$faktura.P_16}</P_16>
            <P_17>{$faktura.P_17}</P_17>
            <P_18>{$faktura.P_18}</P_18>
            <P_19>{$faktura.P_19}</P_19>
            <P_20>{$faktura.P_20}</P_20>
            <P_21>{$faktura.P_21}</P_21>
            <P_23>{$faktura.P_23}</P_23>
            <P_106E_2>{$faktura.P_106E_2}</P_106E_2>
            <P_106E_3>{$faktura.P_106E_3}</P_106E_3>
            <RodzajFaktury>{$faktura.RodzajFaktury}</RodzajFaktury>
      </Faktura>
      {/foreach}

      <FakturaCtrl>
            <LiczbaFaktur>{$FakturaCtrl.LiczbaFaktur}</LiczbaFaktur>
            <WartoscFaktur>{$FakturaCtrl.WartoscFaktur}</WartoscFaktur>
      </FakturaCtrl>

      <StawkiPodatku>
            <Stawka1>0.23</Stawka1>
            <Stawka2>0.08</Stawka2>
            <Stawka3>0.05</Stawka3>
            <Stawka4>0.00</Stawka4>
            <Stawka5>0.00</Stawka5>
      </StawkiPodatku>

      {foreach from=$Wiersze item=wiersz}
      <FakturaWiersz typ="{$wiersz.Typ}">
            <P_2B>{$wiersz.P2_b}</P_2B>
            <P_7>{$wiersz.P_7}</P_7>
            <P_8A>{$wiersz.P_8A}</P_8A>
            <P_8B>{$wiersz.P_8B}</P_8B>
            <P_9A>{$wiersz.P_9A}</P_9A>
            <P_9B>{$wiersz.P_9B}</P_9B>
            <P_11>{$wiersz.P_11}</P_11>
            <P_11A>{$wiersz.P_11A}</P_11A>
            <P_12>{$wiersz.P_12}</P_12>
      </FakturaWiersz>
      {/foreach}

      <FakturaWierszCtrl>
            <LiczbaWierszyFaktur>{$FakturaWierszCtrl.LiczbaWierszyFaktur}</LiczbaWierszyFaktur>
            <WartoscWierszyFaktur>{$FakturaWierszCtrl.WartoscWierszyFaktur}</WartoscWierszyFaktur>
      </FakturaWierszCtrl>
</JPK>
