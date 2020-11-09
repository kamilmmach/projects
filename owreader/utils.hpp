#ifndef _UTILS_HPP_
#define _UTILS_HPP_

#include <cstdio>
#include <cstdint>

struct Utils
{
    static uint8_t crc8(uint8_t *data, uint8_t len)
    {
        int crc = 0;

        for (int i = 0; i < len; ++i)
        {
            uint8_t databyte = data[i];
            for (int j = 0; j < 8; ++j)
            {
                bool crcxor = (crc ^ databyte) & 1;
                crc >>= 1;
                if (crcxor)
                    crc ^= 0x8C;

                databyte >>= 1;
            }
        }

        return crc;
    }
};

#endif // _UTILS_HPP_
