# g++ main.cpp onewire.cpp ds18b20.cpp -o owreader -lbcm2835
LDLIBS=-lbcm2835 -lfmt

owreader: main.cpp onewire.o ds18b20.o
	g++ -O2 -o bin/owreader main.cpp onewire.o ds18b20.o $(LDLIBS)

onewire.o: onewire.cpp onewire.hpp utils.hpp
	g++ -c onewire.cpp
	
ds18b20.o: ds18b20.cpp	ds18b20.hpp utils.hpp
	g++ -c ds18b20.cpp
