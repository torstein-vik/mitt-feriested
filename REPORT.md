# GAS analyse:

### Goals

Målet er å fremme færøyene som et aktuellt reisemål for naturinterreserte i alderen fra 15 til 25.

### Audience

Naturinterreserte i alderen fra 15 til 25.

### Scope

vet da fan....

# Planleggingsstadier:

* Først drøftet vi valg av feriested
* Deretter drøftet vi valg av målgruppe
* Deretter ble vi enig om en tolkning av krav-listen
* Deretter drøftet vi valg av verktøy. Vi kom fram til å bruk en repo på github ([https://github.com/torstein-vik/mitt-feriested](https://github.com/torstein-vik/mitt-feriested)), og det vi ville lokalt (vi begge brukte brackets på grunn av at det er optimalt for git, og generellt sett en veldig bra tekstredigator)
* Deretter ble vi enig om en grov arbeidsfordeling (vi har så klart samarbeidet mye)
  * Torstein har hovedansvar for prosjektstrukutr, backend (inkl. database), og javascript
  * Johannes har hovedansvar for design og stylesheets, samt den lokale DOM-strukturen
  * Delt ansvar for innhold
* Deretter ble vi enig om følgende tidskjema:
  1. Backend og grunnleggende DOM-struktur for det som var felles
  2. Grunnleggende fellesdesign og css-kode for dette
  3. Lage en hjemmeside, med slideshow og fakta
  4. Designe dette og implementere css-en
  5. Lage system for innlogging og registrering, og en database med brukere, samt nettsider for å interagere med systemet
  6. Designe dette og implementere css-en
  7. Lage side for attraksjoner og en database for disse. Inkludert vær, men ikke enda kommentarer
  8. Designe dette og implementere css-en
  9. Lage system for reisetips og implementere dette på attraksjonssiden
  10. Designe dette og implementere css-en
  11. Lage mypage for bruker, og gi mulighet for å administrere reisetips herifra
  12. Designe dette og implementere css-en
  11. Lage kategorier for attraksjonene, som er lett å browse mellom
  12. Designe dette og implementere css-en
  13. Legge inn innhold på nettsida
  14. Behandle bilder for å få alt til å passe
  15. Knytte sammen alle løse tråder, fullføre prosjektet
  16. Rigorøse tester
  
    Å faktisk følge dette tidsskjemaet er såklart veldig ineffektivt, siden Johannes må vente helt til Torstein er ferdig før han kan begynne på design. Derfor er det underforstått at design og backend har gått hånd i hånd. Innhold ventet vi likevel med helt til vi var ferdig.

Mot slutten brukte vi github issues for å holde orden på hva som gjensto. Nettsiden ble til slutt rigorøst testet, både mot hacking og brukerfeil. Vi fant noen få småproblemer, som vi fikset.

# Databasestruktur:

Her er et bilde:

![](http://i.imgur.com/GfSdCBS.png)

På github ([https://github.com/torstein-vik/mitt-feriested](https://github.com/torstein-vik/mitt-feriested)) finner man også en .mwb fil for databasemodellen.

Som du man se er det 5 tabeller:

#### users

Users er tabellen over brukere. Den inneholder simpelthen en unik id som primærnøkkel, et brukernavn, en privilege (enten admin eller user, futureproofing dersom vi etterhvert ønsker å ha admins), og passhash og passsalt. Passsalt er unik tilfeldig sekvens av bytes som har som hensikt å gjør passhash unik selv om flere brukere har samme passord. Passhash er en sha256 hashing av passordet og dette saltet. Denne typen passordsikkerhet er ganske moderne og trygg (frem til noen bruker passorder 'passord123').

#### attractions

attractions er tabellen over attraksjoner. Dette er del av databasen delvis for å kunne spesifiere hvilken attraksjon et reisetips tilhører, men også for å ha færre linjer med kode. Den inneholder attractionid som primærnøkkel, name, som er et kort navn på attraksjonen, pagefile, som er den php-filen som inneholder fakta om attraksjonen, previewimg, som er bildet/logoen som brukes i listen over attraksjoner, og weather, som er hvilken plass vi skal måle vær for.

Vi har laget et lite minisystem for å legge disse attraksjonene inn i databasen. Først endrer vi på attractions.json. Dette er et veldig lett leselig og redigerbart dokument. Deretter kjører vi create_attractions_sql_file.js i nodejs for å lage create_attractions.sql, som er en sql fil som legger inn de riktige attraksjonene (med kategori som vi skal se på senere).

#### tips

Tips er databasen over kommentarer. Feltene er tipid, primærnøkkelen, userid, en fremmednøkkel til hvem som skrev reisetipset, attractionid, en fremmednøkkel til hvilken attraksjon det angår, timestamp, det tidspunktet den ble lagt ut, title, en kort tittel på kommentaren, og content, innholdet til kommentaren.

#### tags

Tags er de kategoriene attraksjonene kan være i. Vi tilater at en attraksjon kan være i flere kategorier samtidig (f.eks. hotel føroyar er både hotell og restaurant), men tags er bare tabellen over selve kategoriene. Kolonnene er tipid, primærnøkkelen, og name, et kort navn til kategorien.

#### tagselections

Tagselections er databasen over 'utvalg' av kategorier (siden vi tilater flere). Denne tabellen sin primærnøkkel er bygd opp av attractionid og tagid, som også er fremmednøkler til attractions og tags henholdsvis.