SIM
===
Projekt demonstrujący symulację fizyczną odbicia piłki od ziemi w przyspieszeniu grawitacyjnym z uwzględnieniem elastyczności oraz tarcia. Stworzony po lekturze pierwszej części książki "Foundations of Physically Based Modeling and Animation" autorstwa D. House'a oraz J. C. Keysera.

Program oblicza położenie punktu w różnych odstępach czasu liczonych od startu symulacji na podstawie warunków początkowych, takich jak położenie początkowe, prędkość początkowa oraz działające przyspieszenie.

W tradycyjnych symulacjach najpopularniejszą metodą obliczenia położenia punktu w sytuacjach, gdzie nie dysponuje się równaniami ruchu, a jedynie wielkościami fizycznymi symulowanych obiektów jest metoda Eulera. Jest to najszybsza i najprostsza obliczeniowo metoda obliczenia numerycznego wykorzystywana przy symulacjach, jednak nie jest to metoda bezbłędna. Wynika to z narastającego błędu obliczeniowego symulacji, który rośnie wraz z rosnącą różnicą czasu dla jednego kroku symulacji. 

W programie tym do całkowania numerycznego wykorzystana została metoda pośrednia, która oblicza położenie punktu na podstawie średniej arytmetycznej z obecnej prędkości oraz prędkości obliczonej po przeprowadzeniu kroku symulacji, co nieweluje błąd metody Eulera.

Do operacji na wektorach wykorzystano bibliotekę GLM.