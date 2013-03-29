Perronskilt (in English)
========================
This is a miniture PHP app, which utilizes Mustache, Bootstrap CSS and a lab feature from the Danish State Railways.

The code here should be considered for fun only, and not suited for production use. Most comments and the main template is intentional in Danish.

***

Perronskilt
===========
Følgende filer indeholder en miniature applikation skrevet i PHP, som benytter Mustache templates,
Bootstrap CSS og DSBLabs API, der giver adgang til at hente blandt andet de kommende afgange for en
given station. Du kan med "Perronskilt" vise en enkelt webside, hvor de kommende tog vises i en simpel tabel.

Koden her er lavet som en simpel demonstration, ikke noget, der er tiltænkt egentlig produktion.

Kilder
------
Denne applikation benytter følgende kilder/dele:
* Listen af s-tog stationer, der findes i stations.txt stammer fra http://trafikinfo.bane.dk/Trafikinformation/Stationsliste
* Mustache.php kommer fra https://github.com/bobthecow/mustache.php - Den vedlagte version er en gammel version, som bestod af en og kun en fil.
* De brugte kald til DSB Labs er beskrevet/dokumenteret pÃ¥ http://dsblabs.dk/webservices
* Dokumentation af Bootstrap findes på http://twitter.github.com/bootstrap/ - den inkluderes fra http://www.bootstrapcdn.com/
* "Find mig" bruger en fuktion fra http://geo.oiorest.dk/ til at finde nærmeste s-tog station.

Andet
-----
* Din PHP installation skal kunne anvende Curl (det kan de fleste webhoteller uden videre).
* Denne PHP er udviklet under PHP 5.4.9, men bør i hvert fald fungere under alle versioner tilbage til PHP 5.2.

Udvikling
---------
Udviklingen af perronskilt kan enkelt ske på en computer, hvis blot PHP er installeret (i version 5.4). Perronskilt kræver
ikke nogen database eller særlige PHP moduler, og kan uden videre afvikles af PHP 5.4's indbyggede webserver.
* Linux: Du kan via din lokale package manager installere PHP 5.4.
* Mac:
 * Det anbefales det at installere PHP 5.4 via http://php-osx.liip.ch/
 * Du kan på Mac'en også benytte den udgave af PHP og Apache webserveren, der følger med OSX.
* Windows: PHP websitet beskriver forskellige måder PHP kan installeres under windows - se http://php.net/manual/en/install.windows.php.

Udeståender og fejl
-------------------
Det er ikke utænkeligt, at denne applikation udvides overtid med en eller flere af følgende funktionaliteter:

* Hvis der er ikke kommer svar fra DSBLab eller det ikke indeholder noget meningsfyldt, tages der ikke pænt hånd om dette.

Hvis du har forslag eller ønsker, er du velkommen til at bidrage med kode eller indrapportere det via Issues på Github, som du finder på:
https://github.com/mahler/perronskilt/issues

Noter om funktioner
===================

Om HTML'en
----------
Perronskilt laver valid HTML5. Det testes normalt i Google Chrome, Firefox og Safri, samt på Android (4.2.x) og iOS6
inden upload til GitHub. Perronskilt bør som udgangspunkt kunne vises af enhver moderne velfungerende browser uden videre.

Nogle af de Javascript funktioner, der bruges til "Find nærmeste" virker muligvis ikke i alle tilfælde (se nærmere nedenfor
i afsnittet "om Find Nærmeste").

Om Cookies
----------
Hvis cookieMananger.php er inkluderet i index.php, så husker perronskilt sitet din seneste valgte station. Alt, der har
med cookies at gøre, er isoleret i denne fil, og indhold i cookies bruges til at manipulere med variable, som index.php
allerede bruger og blot ændrer i en af dem (samt skyder en cookie header med).

Det er et bevist valg, at den blot husker seneste - så skal man som bruger ikke have et sted at vælge "favorit" station.


Om "Find nærmeste"
-------------
"Find nærmeste" bruger (moderne) browseres indbyggede funktionalitet til at finde brugerens GPS position. Umiddelbart virker
det ret fornuftigt på mobil-devices (smartphones, tables og lignende), der har GPS funktionalitet indbygget. Erfaringerne
med desktop browsere (windows, mac, linux) er noget mere blandede. Jeg har en ide om at browserne typisk finder GPS
på baggrund af deres IP-nummer, og at oversættelsen mellem IP nummer og en GPS position ikke er specielt fantastisk.

geoProxy.php findes fordi jeg ikke har kunnet finde ud af at kalde geo.oiorest.dk direkte med et jsonp-kald.
Browserne tillader ikke, at man kalder ajax på tværs af hostnavne og porte, hvis det ikke sker som jsonp (eller via CORS*).
geoProxy.php agerer mellemled og kaldes af index.php via ajax, og kalder selv server-til-server til oiorest.dk - og reurnerer
så svaret til browseren.

*) se mere om CORS på http://www.html5rocks.com/en/tutorials/cors/


Om Analytics
------------
Jeg benytter Google Analytics på stog.mahler.io til at se om der er nogen, der rent faktisk kommer forbi sitet.
I PerronSkilt er det laves således, at man kan lave en fil, der hedder "analytics.txt" i hvilken man kan placere den kode
der skal skydes ind på siden for at lave analytics - uanset om det er Google Analytics eller et andet system.

Hvis analytics.txt ikke findes, så virker sitet stadigt, blot skydes ingen analytics kode ind på siden.

Om footeren (på stog.mahler.io)
-------------------------------
Footeren er lavet ved at tilføje lidt ekstra CSS i index.mustache skabelonen, der styrer dens udseende.
Resten af footeren er skudt ind som lidt ekstra linjer i min analytics.txt fil.


Credits and collaboration
=========================
* CSS hjælp venligst ydet af https://twitter.com/Pattersson

License
=======
All original code provided by in this project is licensed under the MIT license.

Copyright (c) 2012-2013 Flemming Mahler

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"),
to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
ALIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
IN THE SOFTWARE.

- http://opensource.org/licenses/mit-license.php
