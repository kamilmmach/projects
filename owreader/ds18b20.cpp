#include "ds18b20.hpp"
#include "utils.hpp"


bool Ds18b20::ReadTemperature()
{
    ow_interface_->ResetAndPresence();
    ow_interface_->SelectDevice(device_id_);
    
    if(!ConvertT())
        return false;

    ow_interface_->ResetAndPresence();
    ow_interface_->SelectDevice(device_id_);

    uint8_t scratchpad[9];

    // Read scratchpad
    ow_interface_->WriteByte(0xBE);
    for(int i = 0; i < 9; i++)
        scratchpad[i] = ow_interface_->ReadByte();
    
    if(Utils::crc8(scratchpad, 9) != 0)
        return false;

    int t1 = scratchpad[0];
	int t2 = scratchpad[1];

	int16_t temp = (t2 << 8) | t1;

    temperature_ = static_cast<float>(temp) * 0.0625f;
    return true;
}

/**
 * Issues a convert temperature command. Works only in active (not parasite!) mode.
 * @brief Ds18b20::ConvertT
 * @return
 */
bool Ds18b20::ConvertT()
{
    ow_interface_->WriteByte(0x44);

    for(int i = 0; i < 15; ++i)
	{
		bcm2835_delayMicroseconds(100000);
        if(ow_interface_->ReadBit())
			return true;
	}

	return false;
}

uint8_t* Ds18b20::GetROM64()
{
    return ow_interface_->GetROM64(device_id_);
}
