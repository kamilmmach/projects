#ifndef _GLOBALS_H_
#define _GLOBALS_H_

#define ESP_RSTPIN 8

namespace Globals
{
	BasicTimer gTimer;
	Adafruit_PCD8544 gDisplay = Adafruit_PCD8544(7, 6, 5, 4, 12);
	OneWire gOneWire(10); // 10 blocks 16-bit timer1
	DallasTemperature gTempSensors(&gOneWire);
	RTC_DS1307 gRtc;
}

#endif
