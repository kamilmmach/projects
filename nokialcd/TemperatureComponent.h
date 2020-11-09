#ifndef _TEMPERATURECOMPONENT_h
#define _TEMPERATURECOMPONENT_h

#include <DallasTemperature.h>

#include "Component.h"

class TemperatureComponent : public Component
{
public:
	TemperatureComponent() = delete;
	TemperatureComponent(DallasTemperature* SensorManager, uint8_t Index);

	void Update() override;
	void Draw(Adafruit_PCD8544* display) const override;

	float GetCurrentTemperature() const
	{
		return CurrentTemperature;
	}

	uint8_t GetId() const
	{
		return Id;
	}

private:
	uint8_t Id;
	float CurrentTemperature;
	DallasTemperature* DallasSensors;
	DeviceAddress SensorAddress;
};

#endif

