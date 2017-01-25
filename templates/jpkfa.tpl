<?xml version="1.0" encoding="utf-8"?>
<JPK xmlns="{$dane.xmlns}" xmlns:etd="{$dane.xmlns_etd}">

      {assign var='Naglowek' value=$dane.Naglowek}
      <Naglowek>
            <KodFormularza kodSystemowy="{$Naglowek.kodSystemowy}" wersjaSchemy="{$Naglowek.wersjaSchemy}">{$Naglowek.KodFormularza}</KodFormularza>
            <WariantFormularza>{$Naglowek.WariantFormularza}</WariantFormularza>
            <CelZlozenia>{$Naglowek.CelZlozenia}</CelZlozenia>
            <DataWytworzeniaJPK>{$Naglowek.DataWytworzeniaJPK}</DataWytworzeniaJPK>
            <DataOd>{$Naglowek.DataOd}</DataOd>
            <DataDo>{$Naglowek.DataDo}</DataDo>
            <DomyslnyKodWaluty>{$Naglowek.DomyslnyKodWaluty}</DomyslnyKodWaluty>
            <KodUrzedu>{$Naglowek.KodUrzedu}</KodUrzedu>
      </Naglowek>

      {assign var='Podmiot1' value=$dane.Podmiot1}
      <Podmiot1>
         <IdentyfikatorPodmiotu>
            <etd:NIP>{$Podmiot1.NIP}</etd:NIP>
            <etd:PelnaNazwa>{$Podmiot1.PelnaNazwa|escape:html}</etd:PelnaNazwa>
            {if $Podmiot1.Regon}<etd:REGON>{$Podmiot1.Regon}</etd:REGON>{/if}
         </IdentyfikatorPodmiotu>
         <AdresPodmiotu>
            <etd:KodKraju>{$Podmiot1.KodKraju}</etd:KodKraju>
            <etd:Wojewodztwo>{$Podmiot1.Wojewodztwo|escape:html}</etd:Wojewodztwo>
            <etd:Powiat>{$Podmiot1.Powiat|escape:html}</etd:Powiat>
            <etd:Gmina>{$Podmiot1.Gmina|escape:html}</etd:Gmina>
            <etd:Ulica>{$Podmiot1.Ulica|escape:html}</etd:Ulica>
            <etd:NrDomu>{$Podmiot1.NrDomu|escape:html}</etd:NrDomu>
            {if $Podmiot1.NrLokalu}<etd:NrLokalu>{$Podmiot1.NrLokalu|escape:html}</etd:NrLokalu>{/if}
            <etd:Miejscowosc>{$Podmiot1.Miejscowosc|escape:html}</etd:Miejscowosc>
            <etd:KodPocztowy>{$Podmiot1.KodPocztowy|escape:html}</etd:KodPocztowy>
            <etd:Poczta>{$Podmiot1.Poczta|escape:html}</etd:Poczta>
         </AdresPodmiotu>
      </Podmiot1>

      {assign var='Faktury' value=$dane.Faktury}
      {foreach from=$Faktury item=faktura}
      <Faktura typ="{$faktura.Typ}">
            <P_1>{$faktura.P_1}</P_1>
            <P_2A>{$faktura.P_2A|escape:html}</P_2A>
            <P_3A>{$faktura.P_3A|escape:html}</P_3A>
            <P_3B>{$faktura.P_3B|escape:html}</P_3B>
            <P_3C>{$faktura.P_3C|escape:html}</P_3C>
            <P_3D>{$faktura.P_3D|escape:html}</P_3D>
            <P_4A>{$faktura.P_4A|escape:html}</P_4A>
            <P_4B>{$faktura.P_4B|escape:html}</P_4B>
            <P_5A>{$faktura.P_5A|escape:html}</P_5A>
            <P_5B>{$faktura.P_5B|escape:html}</P_5B>
            {if $faktura.P_6}<P_6>{$faktura.P_6}</P_6>{/if}
            {if $faktura.P_13_1}<P_13_1>{$faktura.P_13_1}</P_13_1>{/if}
            {if $faktura.P_13_2}<P_13_2>{$faktura.P_13_2}</P_13_2>{/if}
            {if $faktura.P_13_3}<P_13_3>{$faktura.P_13_3}</P_13_3>{/if}
            {if $faktura.P_13_4}<P_13_4>{$faktura.P_13_4}</P_13_4>{/if}
            {if $faktura.P_13_5}<P_13_5>{$faktura.P_13_5}</P_13_5>{/if}
            {if $faktura.P_13_6}<P_13_6>{$faktura.P_13_6}</P_13_6>{/if}
            {if $faktura.P_13_7}<P_13_7>{$faktura.P_13_7}</P_13_7>{/if}
            {if $faktura.P_14_1}<P_14_1>{$faktura.P_14_1}</P_14_1>{/if}
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
            {if $faktura.PrzyczynaKorekty}<PrzyczynaKorekty>{$faktura.PrzyczynaKorekty|escape:html}</PrzyczynaKorekty>{/if}
            {if $faktura.NrFaKorygowanej}<NrFaKorygowanej>{$faktura.NrFaKorygowanej|escape:html}</NrFaKorygowanej>{/if}
            {if $faktura.OkresFaKorygowanej}<OkresFaKorygowanej>{$faktura.OkresFaKorygowanej}</OkresFaKorygowanej>{/if}
      </Faktura>
      {/foreach}

      {assign var='FakturaCtrl' value=$dane.FakturaCtrl}
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

      {assign var='Wiersze' value=$dane.Wiersze}
      {foreach from=$Wiersze item=wiersz}
      <FakturaWiersz typ="{$wiersz.Typ}">
            <P_2B>{$wiersz.P2_b|escape:html}</P_2B>
            <P_7>{$wiersz.P_7|escape:html}</P_7>
            <P_8A>{$wiersz.P_8A}</P_8A>
            <P_8B>{$wiersz.P_8B}</P_8B>
            <P_9A>{$wiersz.P_9A}</P_9A>
            {if $wiersz.P_9B}<P_9B>{$wiersz.P_9B}</P_9B>{/if}
            <P_11>{$wiersz.P_11}</P_11>
            {if $wiersz.P_11A}<P_11A>{$wiersz.P_11A}</P_11A>{/if}
            <P_12>{$wiersz.P_12|escape:html}</P_12>
      </FakturaWiersz>
      {/foreach}

      {assign var='FakturaWierszCtrl' value=$dane.FakturaWierszCtrl}
      <FakturaWierszCtrl>
            <LiczbaWierszyFaktur>{$FakturaWierszCtrl.LiczbaWierszyFaktur}</LiczbaWierszyFaktur>
            <WartoscWierszyFaktur>{$FakturaWierszCtrl.WartoscWierszyFaktur}</WartoscWierszyFaktur>
      </FakturaWierszCtrl>
</JPK>
