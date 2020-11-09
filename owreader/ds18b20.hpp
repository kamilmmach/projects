#ifndef _DS18B20_HPP_
#define _DS18B20_HPP_

#include <cstdint>

#include "onewire.hpp"

class Ds18b20
{
public:
   Ds18b20(OneWire* ow_interface, uint8_t device_id)
      : temperature_(0.0f), ow_interface_(ow_interface), device_id_(device_id) { }
   
   bool ReadTemperature();
   float GetTemperature() { return temperature_; }
   uint8_t* GetROM64();

private:   
   bool ConvertT();

   float temperature_;

   OneWire* ow_interface_;
   uint8_t device_id_;
};


#endif
