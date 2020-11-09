#include "TemperatureComponent.h"

TemperatureComponent::TemperatureComponent(DallasTemperature* SensorManager, uint8_t Index)
	: DallasSensors(SensorManager), Id(Index)
{
	SensorManager->getAddress(SensorAddress, Index);
}

void TemperatureComponent::Update()
{
	DallasSensors->requestTemperaturesByAddress(SensorAddress);
	CurrentTemperature = DallasSensors->getTempC(SensorAddress);
}

void TemperatureComponent::Draw(Adafruit_PCD8544* display) const
{
	display->setTextColor(BLACK, WHITE);
	display->setCursor(X, Y);
	
	display->print(CurrentTemperature, 1);
	display->print((char)247);
	display->print("C");
}