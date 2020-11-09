#include <iostream>
#include <cstring>

#include "onewire.hpp"
#include "utils.hpp"

bool OneWire::IsUnique()
{
    if (device_length_ == 0)
        return true;

    // Compare rom buffer with every rom in found devices list
    for (int i = 0; i < device_length_; i++)
    {
        if (memcmp(rom_buffer_, devices_[i].rom_num, 8) == 0)
        {
            return false;
        }
    }

    return true;
}

uint8_t OneWire::Discover()
{
    device_length_ = 0;

    ResetSearch();
    while (DeviceSearch())
    {
        // Sometimes, because of bad wiring, a device may report itself multiple times
        // This is a temporary fix, so that every device found is unique

        if (!IsUnique())
        {
            device_length_ = 0;
            ResetSearch();
            continue;
        }

        // Copy ROM number from buffer
        memcpy(devices_[device_length_].rom_num, rom_buffer_, 8);

        device_length_++;
    }

    return device_length_;
}

void OneWire::SendCommand(Command command)
{
    WriteByte(static_cast<uint8_t>(command));
}

bool OneWire::SelectDevice(uint8_t device_id)
{
    if (device_id >= device_length_)
        return false;

    SendCommand(Command::match_rom);

    for (int i = 0; i < 8; i++)
        WriteByte(devices_[device_id].rom_num[i]);

    return true;
}

bool OneWire::DeviceSearch()
{
    if (last_device_flag_)
    {
        ResetSearch();
        return false;
    }

    if (!ResetAndPresence())
    {
        ResetSearch();
        return false;
    }

    // Send Search ROM command
    //WriteByte(0xF0);
    SendCommand(Command::search_rom);

    bool rom_bit = false, rom_bit_cmp = false;
    bool search_direction = false;
    uint8_t rom_bit_number = 1, rom_byte_mask = 1, last_bit_zero = 0, rom_byte_number = 0;

    do
    {
        rom_bit = ReadBit();
        rom_bit_cmp = ReadBit();

        if (rom_bit == true && rom_bit_cmp == true)
        {
            return false;
        }

        // 0 && 1
        if (rom_bit != rom_bit_cmp)
            search_direction = rom_bit;
        else
        {
            if (rom_bit_number < last_discrepancy_)
                search_direction = ((rom_buffer_[rom_byte_number] & rom_byte_mask) > 0);
            else
                search_direction = (rom_bit_number == last_discrepancy_);

            if (search_direction == false)
            {
                last_bit_zero = rom_bit_number;
                if (last_bit_zero < 9)
                    last_family_discrepancy_ = last_bit_zero;
            }
        }

        if (search_direction == true)
            rom_buffer_[rom_byte_number] |= rom_byte_mask;
        else
            rom_buffer_[rom_byte_number] &= ~rom_byte_mask;

        // Tell devices which direction we take so that
        // other devices shut down
        WriteBit(search_direction);

        rom_bit_number++;
        rom_byte_mask <<= 1;

        // Whole byte has been read
        if (rom_byte_mask == 0)
        {
            rom_byte_number++;
            rom_byte_mask = 1;
        }
    } while (rom_byte_number < 8);

    if (!((rom_bit_number < 65) || Utils::crc8(rom_buffer_, 8) != 0))
    {
        last_discrepancy_ = last_bit_zero;

        if (last_discrepancy_ == 0)
            last_device_flag_ = true;

        return true;
    }

    if (!rom_buffer_[0])
        ResetSearch();

    return false;
}

void OneWire::ResetSearch()
{
    last_device_flag_ = false;
    last_discrepancy_ = 0;
    last_family_discrepancy_ = 0;
}

bool OneWire::ResetAndPresence()
{
    // Reset
    bcm2835_gpio_fsel(pin_, BCM2835_GPIO_FSEL_OUTP);
    bcm2835_gpio_write(pin_, LOW);
    bcm2835_delayMicroseconds(480);

    // Read presence
    bcm2835_gpio_fsel(pin_, BCM2835_GPIO_FSEL_INPT);
    bcm2835_delayMicroseconds(70);
    uint8_t b = bcm2835_gpio_lev(pin_);
    bcm2835_delayMicroseconds(410);

    return !b;
}

void OneWire::WriteBit(bool value)
{
    int delay1 = 6, delay2 = 64;
    if (value == false)
    {
        delay1 = 80;
        delay2 = 10;
    }

    bcm2835_gpio_fsel(pin_, BCM2835_GPIO_FSEL_OUTP);
    bcm2835_gpio_write(pin_, LOW);
    bcm2835_delayMicroseconds(delay1);
    bcm2835_gpio_fsel(pin_, BCM2835_GPIO_FSEL_INPT);
    bcm2835_delayMicroseconds(delay2);
}

void OneWire::WriteByte(uint8_t value)
{
    for (int i = 0; i < 8; ++i)
    {
        WriteBit(value & 1);
        value = value >> 1;
    }
}

bool OneWire::ReadBit()
{
    bcm2835_gpio_fsel(pin_, BCM2835_GPIO_FSEL_OUTP);
    bcm2835_gpio_write(pin_, LOW);
    bcm2835_delayMicroseconds(6);
    bcm2835_gpio_fsel(pin_, BCM2835_GPIO_FSEL_INPT);
    bcm2835_delayMicroseconds(8);
    uint8_t b = bcm2835_gpio_lev(pin_);
    bcm2835_delayMicroseconds(55);

    return b;
}

uint8_t OneWire::ReadByte()
{
    uint8_t rbyte = 0;

    for (int i = 0; i < 8; ++i)
    {
        rbyte = rbyte | (ReadBit() << i);
    }
    return rbyte;
}

void OneWire::SkipROM()
{
    SendCommand(Command::skip_rom);
}

uint8_t *OneWire::GetROM64(uint8_t device_id)
{
    return devices_[device_id].rom_num;
}

uint8_t OneWireDevice::GetFamilyCode()
{
    return rom_num[0];
}
