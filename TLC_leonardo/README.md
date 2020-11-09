TLC Leonardo
============
Jest to projekt, który przy pomocy jednego lub więcej 16-kanałowych generatorów PWM TLC5940 pozwala na stworzenie macierzy RGB ("wyświetlacza") na bazie diod RGB ze wspólną anodą.

W kodzie programu można znaleźć implementację komunikacji z układem TLC5940 zrealizowaną na podstawie dokumentacji technicznej układu, jak również prostych abstrakcji w postaci klasy reprezentującej pojedynczy piksel (jedną diodę RGB) oraz wyświetlacza (zbioru pikseli o określonej wysokości i szerokości).

Przesyłanie danych do układów TLC odbywa się w regularnych odstępach czasowych z wykorzystaniem timera sprzętowego.

Główna pętla programu realizuje animację 5 diod RGB ustawionych w jednym rzędzie na podstawie upływającego rzeczywistego czasu.