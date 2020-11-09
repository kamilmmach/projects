#include <string>
#include <ctime>

#include <sched.h>
#include <sys/mman.h>
#include <unistd.h>

#include <fmt/core.h>
#include <bcm2835.h>

#include "ds18b20.hpp"

const int gOneWirePin = RPI_GPIO_P1_07;
const int gMinDevices = 2;
const int gMaxDevices = 8;
const int gIntervalMs = 5000; // Try to update every n ms
const int gReadingAttempts = 1;

std::string getStringROM(Ds18b20* sensor)
{
    std::string rom = "";
    uint8_t* romint = sensor->GetROM64();
    for(int i = 0; i < 8; i++)
    {
        rom += fmt::format("{:02x}", romint[i]);
    }
    return rom;
}

int main()
{
    const struct sched_param priority = {1};
    sched_setscheduler(0, SCHED_FIFO, &priority);
    mlockall(MCL_CURRENT | MCL_FUTURE);

    if(!bcm2835_init())
        return 1;

    bcm2835_gpio_fsel(gOneWirePin, BCM2835_GPIO_FSEL_INPT);

    OneWire ow_interface(gOneWirePin);
    Ds18b20* devices[gMaxDevices] = {nullptr};
    time_t times[gMaxDevices] = {0};

    uint8_t ndevices = 0;

    uint8_t ow_devices_num = 0;

    while((ow_devices_num = ow_interface.Discover()) < gMinDevices);


    for(int i = 0; i < ow_devices_num; ++i)
    {
        if(ow_interface.devices_[i].rom_num[0] == 0x28)
        {
            devices[ndevices] = new Ds18b20(&ow_interface, i);
            ndevices++;
        }
    }

    // Time structures for counting how much to sleep
    timespec timeSleep, timeStart, timeStop;

    FILE* fJSON;

    char timeBuffer[20];
    while(true)
    {
        clock_gettime(CLOCK_MONOTONIC_RAW, &timeStart);
        std::string json = "{";
        for(int i = 0; i < ndevices; i++)
        {
            for(int j = 0; j < gReadingAttempts; j++)
            {
                if(devices[i]->ReadTemperature())
                {
                    time(&times[i]);
                    break;
                }
            }

            json += "\"" + getStringROM(devices[i]) + "\":{";
            json += "\"value\":" + std::to_string(devices[i]->GetTemperature()) + ',';
            tm* timeinfo = localtime(&times[i]);
            strftime(timeBuffer,sizeof(timeBuffer),"%Y-%m-%dT%H:%M:%S", timeinfo);
            json += "\"date\":\"" + std::string(timeBuffer) + "\"}";
            if (i != ndevices - 1)
            {
                json += ",";
            }

        }
        json += "}";
        fJSON = fopen("/usr/share/owreader/readout.json", "w");
        fwrite(json.c_str(), 1, json.size(), fJSON);
        fclose(fJSON);

        // Check how long did it take to make measurements and sleep until the time
        // of the next reading according to the defined gIntervalMs interval
        clock_gettime(CLOCK_MONOTONIC_RAW, &timeStop);
        timeSleep.tv_nsec = ((gIntervalMs % 1000) * 1000000) - (timeStop.tv_nsec - timeStart.tv_nsec);
        timeSleep.tv_sec = (gIntervalMs / 1000) - (timeStop.tv_sec - timeStart.tv_sec); 
        nanosleep(&timeSleep, 0);
    }

}



