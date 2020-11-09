TeamSpeak Request Center (TSRC)
===============================

### DEMO
https://kmach.ga/demo/tsrc/public/

Użytkownicy:

Email (login): admin@admin.pl Hasło: admin Rodzaj: administrator

Email (login): guest@guest.pl Hasło: guest Rodzaj: gość

### Opis aplikacji

TeamSpeak Request Center jest to projekt, który powstał z potrzeby stworzenia systemu do zarządzania wniosków o stworzenie kanału na osobistym, publicznie dostępnym serwerze TeamSpeak. Głównym zamysłem projektu jest to, aby każdy nowy użytkownik, który chciałby mieć swój osobisty kanał chroniony hasłem. Oprócz samych wniosków, ważnym elementem była automatyzacja procesu tworzenia kanału oraz nadawania odpowiednich uprawnień użytkownikowi do zarządzania kanałem.

Aplikacja obecnie nie jest rozwijana i funkcjonalna ze względu na rezygnację z odpłatnego rozwiązania platformy TeamSpeak w momencie pojawienia się lepszej (darmowej) alternatywy, jaką jest Discord.

TSRC powstało w oparciu o framework Laravel w wersji 5.3.

Wykorzystane technologie
------------------------

* Laravel, popularny framework działający w oparciu o PHP,
* Bootstrap 4, jako framework CSS do ułatwienia procesu tworzenia wyglądu strony,
* TeamSpeak 3 PHP Framework, biblioteka umożliwiająca komunikację z serwerami TeamSpeak poprzez PHP,
* widok strony zbudowany został w oparciu o HTML5 oraz silnik szablonów Blade wykorzystywany przez framework Laravel,
* widok panelu administracyjnego oparty został o szablon AdminLTE.

Opis działania aplikacji
------------------------

### Punkt widzenia użytkownika
Użytkownik chcący otrzymać swój własny kanał na serwerze TeamSpeak zobligowany był do rejestracji nowego konta na stronie internetowej. Konto użytkownika zawiera podstawowe informacje, jak login, adres email, oraz identyfikator profilu TeamSpeak (tożsamość), który pozwolił na powiązanie konta użytkownika z tożsamością na serwerze TeamSpeak.

Użytkownik następnie mógł dodać dowolną liczbę wniosków o założenie kanału. Wniosek zawierał informację na temat nazwy kanału, tymczasowego hasła, które służyło do dołączenia do kanału po jego stworzeniu oraz opcjonalnej wiadomości do administracji.

W momencie stworzenia wniosku, system wysyłał każdemu administratorowi wiadomość email z informacją, że stworzony został nowy wniosek.

Do każdego wniosku administrator mógł dodać własne wiadomości, do których mógł ustosunkować się użytkownik składający wniosek.

### Punkt widzenia administratora
Administrator posiadał własny panel administracyjny, z poziomu którego mógł przeglądać wnioski i akceptować je, odrzucać lub wysyłać wiadomości, np. z prośbą o zmianę nazwy kanału ze względu na zawarcie słów niezgodnych z regulaminem serwera.

Po akceptacji wniosku kanał na serwerze był tworzony automatycznie, zgodnie z informacjami podanymi we wniosku.

Z poziomu panelu administratora Administrator mógł również zarządzać użytkownikami, tj. wyszukiwać, usuwać i zmieniać dane użytkowników.

### Automatyzacja tworzenia kanałów
Każdy kanał na serwerze TeamSpeak posiadał określoną strukturę. Część kanałów była przeznaczona tylko dla administratorów, część była ogólnie dostępna, a część zawierała prywatne kanały użytkowników.

Prywatne kanały użytkowników posiadały określoną strukturę, tj. [NUMER] Nazwa kanału. Kanały posortowane były malejąco według numeru. Część nazw kanałów mogła mieć w nazwie RESERVED, co oznaczało, że nikt z danego kanału już nie korzystał i należało w to miejsce stworzyć nowy kanał.

Stworzony algorytm łączył się z serwerem TeamSpeak poprzez specjalny protokół przewidziany do zarządzania serwerem bez udziału aplikacji klienckiej. Robił to za pomocą ogólnodostępnej biblioteki TeamSpeak 3 PHP Framework, którą należało zintegrować z frameworkiem Laravel. Następnie wyszukiwał nieużywany kanał na serwerze spośród sekcji osobistych kanałów. W przypadku gdy taki został znaleziony, usuwał go i tworzył nowy, zgodnie z informacjami zawartymi we wniosku i nadawał uprawnienia użytkownikowi składającemu wniosek.

Modele występujące w aplikacji
------------------------------
* Channel (app/Channel.php) - reprezentuje wniosek o kanał,
* ChannelMessage (app/ChannelMessage.php) - reprezentuje pojedynczą wiadomość do wniosku o kanał,
* User (app/User.php) - użytkownik systemu. Rozszerza podstawowego użytkownika dostarczanego przez framework Laravel. Oprócz 
* Role (app/Role.php) - rola użytkownika, związana z jego uprawnieniami. W aplikacji przewidziane zostały dwie: administrator i zwykły użytkownik. Abstrakcja do modelu pozwala na potencjalnie stworzenie nowych ról i nadanie im konkretnych uprawnień,
* Status (app/Status.php) - status wniosku. Przewidziane są trzy statusy wniosku: w oczekiwaniu na odpowiedź administratora, zaakceptowany oraz odrzucony.

Wszystkie dane, które były wymagane odgórnie, jak statusy wniosku, czy role użytkowników i główne konto administratora tworzone były podczas inicjacji bazy danych wartościami początkowymi (pliki w katalogu database/seeds).

Definicja bazy danych wyrażona została za pomocą systemu migracji Laravel (migracje znajdują się database/migrations).

Inne informacje
---------------
Aplikacja ponadto wykorzystuje wiele funkcjonalności dostarczanych przez framework Laravel. Między innymi aplikacja sprawdza czy wysyłane żądania są zgodne z założeniami dotyczącymi treści (np. czy adres email jest poprawny lub hasło spełnia wymagania dotyczące długości) (app/Http/Requests), czy użytkownik próbujący odnieść się do zasobu posiada wymagane uprawnienia (app/Policies).