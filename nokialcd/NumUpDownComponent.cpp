#include "NumUpDownComponent.h"

void NumUpDownComponent::Draw(Adafruit_PCD8544* display) const
{
	if (bIsSelected)
	{
		if (BlinkState)
			display->setTextColor(WHITE, BLACK);
		else
			display->setTextColor(BLACK, WHITE);
	}
	else
	{
		if (bIsFocused)
			display->setTextColor(WHITE, BLACK);
		else
			display->setTextColor(BLACK, WHITE);
	}

	display->setCursor(X, Y);
	display->print(CurrentValue, 10);
}