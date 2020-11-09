#include "TimerComponent.h"

void TimerComponent::Update()
{
	uint32_t CurrentTime = millis();
	if (CurrentTime - LastTime >= Interval)
	{
		LastTime = CurrentTime;

		if (TickCallback != nullptr)
			TickCallback();
	}
}