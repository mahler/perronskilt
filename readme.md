Perronskilt (in English)
========================
This is a miniture PHP app, which utilizes Mustache, Bootstrap CSS and a lab feature from the Danish State Railways.

The code here should be considered for fun only, and not suited for production use. Most comments and the main template is intentional in Danish.

***

Perronskilt
===========
Følgende filer indeholder en miniature applikation skrevet i PHP, som benytter Mustache templates, Bootstrap CSS og DSBLabs API, der giver adgang til at hente blandt andet de kommende afgange for en given station. Du kan med "Perronskilt" vise en enkelt webside, hvor de kommende tog vises i en simpel tabel.

Koden her er lavet som en simpel demonstration, ikke noget, der er tiltænkt egentlig produktion. 

Kilder
------
Denne applikation benytter følgende kilder/dele:

* Listen af s-tog stationer, der findes i stations.txt stammer fra http://trafikinfo.bane.dk/Trafikinformation/Stationsliste
* Mustache.php kommer fra https://github.com/bobthecow/mustache.php - Den vedlagte version er en gammel version, som bestod af en og kun en fil.
* De brugte kald til DSB Labs er beskrevet/dokumenteret på http://dsblabs.dk/webservices
* Dokumentation af Bootstrap findes på http://twitter.github.com/bootstrap/ - den inkluderes fra http://www.bootstrapcdn.com/

Andet
-----
* Din PHP installation skal kunne anvende Cur (det kan de fleste webhoteller uden videre).
* Denne PHP er udviklet under PHP 5.4.9, men bør i hvert fald fungere under alle versioner tilbage til PHP 5.2.


Udeståender og fejl
-------------------
Det er ikke utænkeligt, at denne applikation udvides overtid med en eller flere af følgende funktionaliteter:

* Cookie til at huske en default station - lige nu er Sydhavnen lagt ind som fast standard.
* Hvis der er ikke kommer svar fra DSBLab eller det ikke indeholder noget meningsfyldt, tages der ikke pænt hånd om dette.

Hvis du har forslag eller ønsker, er du velkommen til at bidrage med kode eller indrapportere det via Issues på Github, som du finder på:
https://github.com/mahler/perronskilt/issues


Credits and collaboration
=========================
* CSS hjælp venligst ydet af https://twitter.com/Pattersson

License
=======
All original code provided by in this project is licensed under the MIT license.

Copyright (c) 2012 Flemming Mahler 

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), 
to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
ALIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS 
IN THE SOFTWARE.

- http://opensource.org/licenses/mit-license.php



D
All original code here is licensed under the MIT License - http://opensource.org/licenses/mit-license.php
