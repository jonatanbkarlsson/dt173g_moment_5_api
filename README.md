# DT173G - Webbutveckling III Moment 5 (API)

API-delen av moment 5 löstes genom att lokalt köra via applikationen [MAMP](https://www.mamp.info/en/windows/) där jag testade PHP och satte upp en MYSQL-databas med hjälp av [phpMyAdmin](https://www.phpmyadmin.net/). Jag skapade först en config-fil som innehåller alla uppgifter för databaskopplingen sedan ansluter jag databasen med hjälp av PDO. Jag skapar sedan en fil som ska hantera alla anrop så som GET, POST, PUT och DELETE. Här läser jag anropen och tar in den medskickade datan och skickar vidare till en annan fil där jag hanterar själva SQL-frågorna till servern.

* Klient: http://studenter.miun.se/~joka1713/dt173g/moment5
* API: http://studenter.miun.se/~joka1713/dt173g/moment5/api/courses.php
