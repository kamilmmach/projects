#ifndef _ONEWIRE_HPP_
#define _ONEWIRE_HPP_

#include <bcm2835.h>

struct OneWireDevice
{
    uint8_t rom_num[8];
    
    uint8_t GetFamilyCode();
};

class OneWire
{
public:
    enum class Command : uint8_t
    {
        read_rom = 0x33,
        match_rom = 0x55,
        skip_rom = 0xCC,
        alarm_search = 0xEC,
        search_rom = 0xF0
    };

    
    OneWire(uint8_t pin)
        : device_length_(0), pin_(pin) {}
    
    uint8_t Discover();
    uint8_t DiscoverFamily(uint8_t family);

    bool ResetAndPresence();
    void SkipROM();
    bool SelectDevice(uint8_t device_id);

    void SendCommand(OneWire::Command command);

    void WriteBit(bool value);
    void WriteByte(uint8_t value);

    bool ReadBit();
    uint8_t ReadByte();
    bool IsUnique();

    uint8_t* GetROM64(uint8_t device_id);

    uint8_t device_length_;
    OneWireDevice devices_[8];

private:
    bool DeviceSearch();
    void ResetSearch();

    uint8_t pin_;

    // Discovery variables
    uint8_t last_discrepancy_;
    uint8_t last_family_discrepancy_;
    bool last_device_flag_;

    uint8_t rom_buffer_[8];

};

#endif
