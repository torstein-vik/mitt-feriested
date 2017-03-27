# GAS analyse:

### Goals

Målet med denne nettsiden er å fremme Færøyene som et aktuelt reisemål. Færøyene er kjent for sin enestående natur, men dette er det ikke alle som vet og de fleste tenker ikke over at Færøyene kan være en feriedestinasjon. Denne nettsiden har som mål å vise Færøyene fra sin beste side og hva det har å by på og målet er at flere skal vurdere det som en feriedestinasjon. Nettsiden skal også hjelpe turister med å planlegge en eventuell ferie, ved å gi informasjon.

### Audience

Målgruppen er hovedsakelig naturinteresserte i alderen fra 15 til 25, men vi sikter også til de som har lyst til å prøve noe nytt og vi fremstiller derfor Færøyene som noe litt uoppdaget og eventyrlig, for å fenge alle som kanskje har lyst til å prøve noe annet enn for eksempel en badeferie i Syden.

### Scope

Denne nettsiden tilbyr nyttig informasjon som kan hjelpe turister med å planlegge et opphold på Færøyene. Den tilbyr en rekke populære attraksjoner, hoteller, restauranter og transportalternativer, samt mye informasjon og nyttige opplysninger om disse. Men nettsiden har også en plattform for turister, hvor de kan tilføye reisetips om attraksjonene. Slike tips kan gjøre det enklere å velge mellom alle alternativene.

# Designvalg:

Her skal vi forklare noen av tankene bak nettsidens stil og designe. Vi tok utgangspunkt i GAS analysen. Siden målgruppen er mellom 15 og 23 år har vi gått for en moderne stil.

Først lagde vi en fargepalett, ved hjelp av bilder fra Færøyene. Her fokuserte vi på naturen fordi vi føler at det er ikonisk for Færøyene. Før vi designet selve nettsiden lagde vi logoen. Den er inspirert av Færøyenes karakteristiske natur. Dens store bølger, skarpe klipper og sitt grønne gress på overflaten ser man tydelig i logoen. 

Deretter designet vi selve nettsiden. Vi tok bruk samme stilen som i logoen. De skarpe kantene og litt merkelig formene ser man glimt av overalt i nettsiden. Fargene fra fargepaletten einer seg dårlig som bakgrunnsfarge fordi de tar blikkfanget. Men de tas i bruk i små mengder på steder hvor vi ønsker oppmerksomhet. Overskriftene spesielt får mye oppmerksomhet på grunn av den grønne fargen. Dette går igjen i hele nettsiden og gjør det enklere for brukeren å raskt finne frem.

# Planleggingsstadier:

* Først drøftet vi valg av feriested
* Deretter drøftet vi valg av målgruppe
* Deretter ble vi enig om en tolkning av krav-listen
* Deretter drøftet vi valg av verktøy. Vi kom fram til å bruke en repo på github ([https://github.com/torstein-vik/mitt-feriested](https://github.com/torstein-vik/mitt-feriested)), og det vi ville lokalt (vi begge brukte brackets på grunn av at det er optimalt for git, og generelt sett en veldig bra tekstredigerer)
* Deretter ble vi enig om en grov arbeidsfordeling (vi har så klart samarbeidet mye)
  * Torstein har hovedansvar for prosjektstruktur, backend (inkl. database), og javascript
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
  
    Å faktisk følge dette tidsskjemaet er så klart veldig ineffektivt, siden Johannes må vente helt til Torstein er ferdig før han kan begynne på design. Derfor er det underforstått at design og backend har gått hånd i hånd. Innhold ventet vi likevel med helt til vi var ferdig.

Mot slutten brukte vi github issues for å holde orden på hva som gjensto. Nettsiden ble til slutt rigorøst testet, både mot hacking og brukerfeil. Vi fant noen få småproblemer, som vi fikset.

# Databasestruktur:

Her er et bilde:

![](http://i.imgur.com/GfSdCBS.png)

På github ([https://github.com/torstein-vik/mitt-feriested](https://github.com/torstein-vik/mitt-feriested)) finner man også en .mwb fil for databasemodellen.

Som man kan se er det 5 tabeller:

#### users

Users er tabellen over brukere. Den inneholder simpelthen en unik id som primærnøkkel, et brukernavn, en privilege (enten admin eller user, future proofing dersom vi etterhvert ønsker å ha admins (Dette er av ENUM-typen så det er 1.normalform)), og passhash og passsalt. Passsalt er unik tilfeldig sekvens av bytes som har som hensikt å gjøre passhash unik selv om flere brukere har samme passord. Passhash er en sha256 hashing av passordet og dette saltet. Denne typen passordsikkerhet er ganske moderne og trygg (frem til noen bruker passordet 'passord123').

#### attractions

attractions er tabellen over attraksjoner. Dette er del av databasen delvis for å kunne spesifisere hvilken attraksjon et reisetips tilhører, men også for å ha færre linjer med kode. Den inneholder attractionid som primærnøkkel, name, som er et kort navn på attraksjonen, pagefile, som er den php-filen som inneholder fakta om attraksjonen, previewimg, som er bildet/logoen som brukes i listen over attraksjoner, og weather, som er hvilken plass vi skal måle vær for.

Vi har laget et lite minisystem for å legge disse attraksjonene inn i databasen. Først endrer vi på attractions.json. Dette er et veldig lett leselig og redigerbart dokument. Deretter kjører vi create_attractions_sql_file.js i nodejs for å lage create_attractions.sql, som er en sql fil som legger inn de riktige attraksjonene (med kategori som vi skal se på senere).

#### tips

Tips er databasen over kommentarer. Feltene er tipid, primærnøkkelen, userid, en fremmednøkkel til hvem som skrev reisetipset, attractionid, en fremmednøkkel til hvilken attraksjon det angår, timestamp, det tidspunktet den ble lagt ut, title, en kort tittel på kommentaren, og content, innholdet til kommentaren.

#### tags

Tags er de kategoriene attraksjonene kan være i. Vi tillater at en attraksjon kan være i flere kategorier samtidig (f.eks. hotel føroyar er både hotell og restaurant), men tags er bare tabellen over selve kategoriene. Kolonnene er tipid, primærnøkkelen, og name, et kort navn til kategorien.

#### tagselections

Tagselections er databasen over 'utvalg' av kategorier (siden vi tillater flere). Denne tabellen sin primærnøkkel er bygd opp av attractionid og tagid, som også er fremmednøkler til attractions og tags henholdsvis.

# Mappe- og filstruktur:

### Mapper

##### /
Dette er rootmappa. Den inneholder noen grunnleggende beskrivelsesfiler

##### /database
Inneholder filer relatert til beskrivelse, fornying, og opprettholding av databasen

##### /domain name
Inneholder filer relatert til valg av domenenavn

##### /palette
Inneholder fargepaletten

##### /ssl certificate
Inneholder filer relatert til ssl-sertifikat

##### /src/
Denne mappa inneholder selve kildekoden. src er også mappa som virtual host-en peker til

##### /src/res/
Denne mappa inneholder bilder og logoer

##### /src/attr/
Denne mappa inneholder php-filer med innhold og en preview image for alle attraksjonene. Vi lister ikke opp disse filene under, siden det er veldig mange

### Filer

##### LICENSE
Lisensfil. Dette prosjektet er under GPL 3.0

##### README.md
Readme fil, kort beskrivelse og installeringsinstruksjoner

##### REPORT.md
Rapportfil. Altså denne filen

##### database/attractions.json
Json fil av attraksjoner og kategorier

##### database/create_attractions.sql
SQL fil som legger in alle attraksjonene

##### database/create_attractions_sql_file.js
Javascript (Nodejs) fil som gjør attractions.json om til create_attractions.sql

##### database/create_database.sql
SQL fil som lager databasen

##### database/database_model.mwb
Databasemodellfil

##### database/database_model.mwb.bak
Backup av databasemodellfilen

##### domain name/domain.md
Inneholder domenenavnet

##### domain name/domain.png
Bilde av at domenet var ledig

##### palette/palette.pdf
Fargepaletten vår

##### src/api.php
API-en for å interagere med databasen. Brukes til login/registrering, legge til/slette kommentarer, hente inn attraksjoner gitt kategorier

##### src/attractions.css
CSS-fil for attractions-siden

##### src/attractions.js
Javascript for å hente inn attractions med ajax og for å få kategoriknappene til å fungere

##### src/attractions.php
Siden som lar deg browse attraksjoner

##### src/contact.css
Stylesheet for contact-siden

##### src/contact.php
En liten kontakt-side, med github og fake-e mailadresser

##### src/home.css
Stylesheet for home

##### src/home.js
Javascript for slideshow

##### src/home.php
Hjemmesida, med litt fakta og bilde

##### src/index.css
Stylesheet for alle sidene

##### src/index.php
Hovedfila som alle andre sider går gjennom, unntatt api. Legger til nav, boksen i midten, og mye annet backend

##### src/login.js
Javascript for loginsida, sender ajax når man logger inn, og viser feilmeldinger. Omdirigerer også etter suksess

##### src/login.php
Sida hvor man kan logge seg inn

##### src/logout.php
Side som logger deg ut

##### src/mypage.css
Stylesheet for mypage

##### src/mypage.js
Javascript for mypage som setter ut en bekreftelsesboks for å slette kommentarer

##### src/mypage.php
Mypage, som lar deg se over og slette kommentarer

##### src/notfound.php
Notfound, som kommer opp når man går til en side som ikke finnes (både på ?page= og ellers)

##### src/register.js
Javascript for å kjøre ajax og vise feilmeldinger på registrering

##### src/register.php
Side for å registrere seg som bruker

##### src/res/birdwatching.ss.jpg
Slideshowbilde av fugler

##### src/res/black_logo.png
En svart logo/vannmerke å ha i høyre bunn av nettsida

##### src/res/favicon.png
icon-et til nettsida

##### src/res/gásadalur.ss.jpg
Slideshowbilde av gásadulur

##### src/res/kirkjubøargarður.ss.jpg
Slideshowbilde av kirkjubøargarður

##### src/res/logo_transparent_text.png
Hovedlogoen, som er i øvre venstre hjørne

##### src/slideshow.php
Slideshow, del av hjemmesida utenfor boksen (loada inn som external i index.php)

##### ssl certificate/faroeadventures.com.crt
ssl-sertifikat for nettsida

##### ssl certificate/faroeadventures.com.csr
ssl-sertifikat signerings-forespørsel, klart for godkjenning av en CA, samt public key

##### ssl certificate/faroeadventures.com.key
Kryptert RSA privatnøkkel for nettsida

##### ssl certificate/faroeadventures.com.nopass.key
Ukryptert RSA privatnøkkel for nettsida

##### ssl certificate/root.ca.crt
ssl-sertifikat for oss som bedrift

##### ssl certificate/root.ca.key
Kryptert RSA privatnøkkel for oss som bedrift

##### ssl certificate/root.srl
Serienummer for vår certificate request
