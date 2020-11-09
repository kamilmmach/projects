SourceQuery
===========
Demo: https://kmach.ga/demo/SourceQuery/

Projekt ten przedstawia podstawową implementację protokołu SourceQuery. SourceQuery jest protokołem pozwalającym na uzyskanie podstawowych informacji o serwerach gier opartych na silniku Source. Korzysta z komunikacji po UDP.

Implementacja pozwala na uzyskanie podstawowych informacji dot. serwera, takich jak nazwa, rozgrywana mapa, tryb gry, rodzaj gry, liczby graczy itp. Pozwala również na uzyskanie informacji o graczach aktualnie grających, takie jak pseudonim, długość połączenia z serwerem czy też wynik.

Dodatkowo zawarty tutaj został mechanizm cache-owania (zaimplementowany w klasie classes/Cache.php), który umożliwia zapisanie danych lokalnie w pliku przez wybrany okres, tak, aby w przypadku wielu wizytujących osób w zbliżonym czasie nie odpytywać niepotrzebnie serwera na nowo.