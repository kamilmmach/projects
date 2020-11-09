#pragma once

#include "Component.h"

class TimerComponent : public Component
{
public:
	TimerComponent()
		: Interval(1000)
	{
		Reset();
	}

	void Update();

	void Reset()
	{
		LastTime = millis();
	}

	void SetTickCallback(void(*c)())
	{
		TickCallback = c;
	}

	void SetInterval(uint32_t NewInterval)
	{
		Interval = NewInterval;
	}

	void OnActivateView() override
	{
		Reset();
	}

	void Draw(Adafruit_PCD8544* display) const {};

private:
	void (*TickCallback)() = nullptr;

	uint32_t Interval;
	uint32_t LastTime;
};