#include <Arduino.h>

#include "BasicTimer.h"

BasicTimer::BasicTimer()
	: DeltaTime(0), PreviousTime(0), CurrentTime(0), BaseTime(0)
{
}

void BasicTimer::Reset()
{
	CurrentTime = millis();
	BaseTime = CurrentTime;
	PreviousTime = CurrentTime;
}

void BasicTimer::Tick()
{
	CurrentTime = millis();
	DeltaTime = CurrentTime - PreviousTime;

	PreviousTime = CurrentTime;
}

unsigned long BasicTimer::GetDeltaTime() const
{
	return DeltaTime;
}

unsigned long BasicTimer::GetAbsoluteTime() const
{
	return (CurrentTime - BaseTime);
}

