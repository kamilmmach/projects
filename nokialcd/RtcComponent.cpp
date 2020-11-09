#include "RtcComponent.h"

const char* RtcComponent::DaysOfTheWeek[7] = { "nie", "pon", "wto", "\x02ro", "czw", "pi\x01", "sob" };

void RtcComponent::Draw(Adafruit_PCD8544* display) const
{
	display->setTextColor(BLACK, WHITE);

	display->setTextSize(1);
	display->setCursor(X + 12, Y + 0);
	display->print(DaysOfTheWeek[CurrentTime.dayOfTheWeek()]);
	display->print(", ");

	if (CurrentTime.day() < 10)
		display->print("0");
	display->print(CurrentTime.day());
	display->print(".");

	if (CurrentTime.month() < 10)
		display->print("0");
	display->print(CurrentTime.month());

	display->setTextSize(3);

	if (bShouldDrawColon)
	{
		display->setCursor(X + 33, Y + 12);
		display->print(":");
	}

	display->setCursor(X + 3, Y + 12);
	if (CurrentTime.hour() < 10)
		display->print("0");
	display->print(CurrentTime.hour());

	display->setCursor(X+45, Y+12);
	if (CurrentTime.minute() < 10)
		display->print("0");
	display->print(CurrentTime.minute());
	display->setTextSize(1);
	
}

void RtcComponent::Update()
{
	Timer.Tick();

	CurrentTime = Rtc->now();

	if (Timer.GetAbsoluteTime() >= 1000)
	{
		bShouldDrawColon = !bShouldDrawColon;
		Timer.Reset();
	}
}

