#ifndef _RTCCOMPONENT_H_
#define _RTCCOMPONENT_H_

#include <RTClib.h>

#include "Component.h"
#include "BasicTimer.h"

class RtcComponent : public Component
{
public:
	RtcComponent(RTC_DS1307* RtcPointer)
		: bShouldDrawColon(false), Rtc(RtcPointer)
	{
	}

	virtual void Update();
	virtual void Draw(Adafruit_PCD8544* display) const;

	virtual void Init()
	{
		while (!Rtc->isrunning())
		{
			Serial.println("RTC Module is not running");
			Serial.println(" Adjusting time...");
			Rtc->adjust(DateTime(F(__DATE__), F(__TIME__)));
		}
	}


	static const char* DaysOfTheWeek[7];

private:
	bool bShouldDrawColon;
	BasicTimer Timer;
	RTC_DS1307* Rtc;
	DateTime CurrentTime;
	
};

#endif
