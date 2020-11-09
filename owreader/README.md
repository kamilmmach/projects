OWREADER
========
Owreader jest aplikacją przeznaczoną na Raspberry Pi pod systemy Linux, która wyszukuje podłączone po magistrali 1-Wire sensory temperatury DS18B20, a następnie umożliwia wykonanie i odczytanie pomiarów oraz zapis tych danych na dysku co określony czas.

W kodzie programu zdefiniowane są dwie główne klasy:
* OneWire - klasa główna, która umożliwia komunikację po magistrali 1-Wire. Oferuje podstawowe funkcje, zaimplementowane własnoręcznie, które umożliwiają wyszukiwanie (odkrywanie) podłączonych do magistrali urządzeń, wybieranie ich do komunikacji oraz wysyłanie im wiadomości,
* DS18B20 - klasa, które implementuje konkretne urządzenie komunikujące się przez magistralę 1-Wire. Interfejs pozwala na wykonanie pomiaru i odczyt bieżącej temperatury.

Aplikacja zapisuje do pliku informacje o adresie urządzenia, daty odczytu oraz wartości odczytu w ustalonym na sztywno formacie JSON.

Program musi działać w trybie administratora ze względu na wymagania związane z zachowaniem odpowiednich ram czasowych przesyłanych sygnałów. Linux jako system ogólnego przeznaczenia może wywłaszczyć proces w dowolnym momencie, uniemożliwiając prawidłową komunikację po interfejsie 1-Wire, ze względu na wymagania czasowe. Dlatego też program po uruchomieniu musi zmienić politykę planisty, do zmiany której wymagane są uprawnienia administratora. W przypadku tego programu użyta została polityka FIFO (First-in, first-out) z wysokim priorytetem procesu, co umożliwia prawidłowe działanie aplikacji. 

### ThingSpeak
Dodatkowo częścią projektu jest skrypt napisany w języku Python (room_temp.py zlokalizowany w katalogu bin), który co minutę odczytuje plik wygenerowany przez program owreader, a następnie przesyła dane o temperaturze do chmury serwisu ThingSpeak. Kolekcjonowane dane są dostępne na stronie https://thingspeak.com/channels/82797