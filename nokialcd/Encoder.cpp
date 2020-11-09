#include "Encoder.h"

void Encoder::Update()
{
	States[1] = States[2] = false;
	
	uint8_t CurrentAValue = digitalRead(PinA);

	if (CurrentAValue != LastAValue)
	{
		if (digitalRead(PinB) != CurrentAValue)
		{
			if(PositionCount % 2)
				States[1] = true;
			PositionCount++;
		}
		else
		{
			if (PositionCount % 2)
				States[2] = true;
			PositionCount--;
		}
	}

	States[0] = !digitalRead(PinButton);
	LastAValue = CurrentAValue;
}

bool Encoder::CheckActivity(Activity a)
{
	switch (a)
	{
	case Encoder::Activity::ButtonPress:
		return States[0];
		break;
	case Encoder::Activity::RotationClockwise:
		return States[1];
		break;
	case Encoder::Activity::RotationAnticlockwise:
		return States[2];
		break;
	}

	return false;
}