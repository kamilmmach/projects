Vector
======
Znaleźć tutaj można klasy implementujące matematyczne wektory - Vector dla wektorów 3D oraz Vector2D dla wektorów 2D.

Główną zaletą implementacji jest uwzględnienie niedoskonałości reprezentacji liczb zmiennoprzecinkowych w standardzie IEEE 754 (wykorzystywanej w popularnych architekturach procesorów, jak x86 czy ARM).

Niedoskonałości te mogą spowodować, że dwie liczby, które w istocie teoretycznie powinny być takie same, ze względu na przeprowadzeniu na nich różnych operacji arytmetycznych, mogą się nieznacznie między sobą różnić. Przy porównaniu dwóch liczb (==) zatem może okazać się, że przez tę niedoskonałość różnią się między sobą, a tak być nie powinno. W związku z tym należy rozpatrywać równość w kontekście pewnej tolerancji ich różnic i moja implementacja w ten sposób rozwiązuje ten problem.