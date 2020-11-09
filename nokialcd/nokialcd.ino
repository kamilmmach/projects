#include <SerialESP8266wifi.h>
#include <DallasTemperature.h>
#include <RTClib.h>
#include <Adafruit_GFX.h>
#include <Adafruit_PCD8544.h>

#include "BasicTimer.h"
#include "Encoder.h"
#include "Globals.h"
#include "MainView.h"


bool sendEspCmd(const char* cmd, char* response, int wait_time = 500);
bool sendEspCmd(unsigned int cmd, char* response, int wait_time = 500);
bool sendEspCmdNoNL(uint8_t* cmd, size_t size, char* response, int wait_time = 500);
void sendEspCmdNoNL(char* cmd);
void UpdateThingSpeak();
bool ESPWatchDog();
unsigned long GetNTPData();



void setup()
{
	Serial.begin(115200);

	// For ESP8266
	Serial1.begin(115200);

	while (!Serial1);

	pinMode(LED_BUILTIN, OUTPUT);
	pinMode(ESP_RSTPIN, OUTPUT);

	digitalWrite(LED_BUILTIN, 0);
	digitalWrite(ESP_RSTPIN, 1);

	delay(1000);
	
	Globals::gTimer.Reset();

	Globals::gTempSensors.begin();

	Serial.println("Setup: Display");
	Globals::gDisplay.begin(60);
	Globals::gDisplay.clearDisplay();
	Globals::gDisplay.setTextWrap(false);

	Serial.println("Setup: RTC");
	Globals::gRtc.begin();

	

	Serial.println("Setup: WiFi");


	if (ESPWatchDog())
	{
		Serial.println("Connected!");
	}
	else
	{
		Serial.println("Couldn't connect :(");
	}


	while (!sendEspCmd("AT", "OK"))
	{
		Serial.println(" Can't connect to ESP8266!");
		delay(1000);
	}

	if (!sendEspCmd("AT+CWJAP_CUR?", "testnetwork", 2000))
	{
		Serial.println(" Connecting to AP");
		while (!sendEspCmd("AT+CWJAP_CUR=\"testnetwork\",\"password\"", "OK", 5000))
		{
			Serial.println("  Can't connect to AP");
		}
	}

	Globals::gRtc.adjust(DateTime(GetNTPData()));

	Serial.println("Setup: MainView");
	SetupMainView();
	Serial.println("Setup: CurrentView 0");
	ViewManager::SetCurrentView(0);

}

void loop()
{
	Globals::gTimer.Tick();

	if (Globals::gTimer.GetAbsoluteTime() >= 60000)
	{
		Globals::gTimer.Reset();
		Serial.println("Loop: update ts");
		UpdateThingSpeak();

	}


	View* currentView = ViewManager::GetCurrentView();

	Encoder::instance().Update();
	currentView->Update();

	Globals::gDisplay.clearDisplay();
	currentView->Draw(&Globals::gDisplay);
	Globals::gDisplay.display();
	
}

void UpdateThingSpeak()
{
	if (!ESPWatchDog())
	{
		Serial.println("Connection to WiFi failed.");
		return;
	}

	Serial.println("Connecting to thingspeak...");
	sendEspCmd("AT+CIPSTART=\"TCP\",\"api.thingspeak.com\",80", "OK", 1000);
	char temp[5];
	dtostrf(MVTemperature.GetCurrentTemperature(), 4, 1, temp);

	if (sendEspCmd("AT+CIPSEND=50", ">", 1000))
	{
		sendEspCmdNoNL("GET /update?api_key=CIACH");
		sendEspCmdNoNL(temp);
		sendEspCmdNoNL("\r\n ");
	}
	delay(200);
	sendEspCmd("AT+CIPCLOSE", "OK");
}

unsigned long GetNTPData()
{
	Serial.println("NTP...");
	unsigned long timestamp = 0;

	sendEspCmd("AT+CIPSTART=\"UDP\",\"0.pl.pool.ntp.org\",123", "OK");
	
	if (sendEspCmd("AT+CIPSEND=48", ">", 1000))
	{
		uint8_t NTPPacket[] = {
			0xe3, 0x00, 0x06, 0xec, 0x00, 0x00, 0x00, 0x00,
			0x00, 0x00, 0x00, 0x00, 0x4c, 0x4f, 0x43, 0x4c,
			0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
			0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
			0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
			0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00
		};

		if (sendEspCmdNoNL(NTPPacket, 48, "OK", 2000))
		{
			while (Serial1.read() != ':');

			if (Serial1.available() > 0)
			{

				for (int i = 0; i < 40; ++i)
				{
					Serial1.read();
				}

				for (uint8_t i = 0; i < 4; ++i)
				{
					timestamp = timestamp << 8 | Serial1.read();
				}

				while (Serial1.available() > 0)
				{
					Serial1.read();
				}
			}
		}
	}
	sendEspCmd("AT+CIPCLOSE", "OK");
	Serial.println("NTP DONE");
	return (timestamp - 2208988800ul) + 3600;
}

bool ESPWatchDog()
{
	for (int i = 0; i < 4; ++i)
	{
		if (i == 3) // hard reset
		{
			digitalWrite(ESP_RSTPIN, 0);
			delay(1000);
			digitalWrite(ESP_RSTPIN, 1);
			delay(4500);
		}

		delay(1000);
		if (!sendEspCmd("AT", "OK"))
			continue;

		if (!sendEspCmd("AT+CWJAP_CUR?", "testnetwork"))
		{
			if (sendEspCmd("AT+CWJAP_CUR=\"testnetwork\",\"password\"", "OK", 5000))
				return true;
		}
		else
			return true;
	}

	return false;
}

#if 1
bool sendEspCmd(const char* cmd, char* response, int wait_time = 500)
{
	Serial1.println(cmd);
	delay(wait_time);
	while (Serial1.available() > 0)
	{
		if (Serial1.find(response))
			return true;
	}
	return false;
}

bool sendEspCmdNoNL(uint8_t* cmd, size_t size, char* response, int wait_time = 500)
{
	Serial1.write(cmd, size);
	delay(wait_time);

	while (Serial1.available() > 0)
	{
		if (Serial1.find(response))
			return true;
	}

	return false;

}

bool sendEspCmd(unsigned int cmd, char* response, int wait_time = 500)
{
	Serial1.println(cmd);
	delay(wait_time);
	while (Serial1.available() > 0)
	{
		if (Serial1.find(response))
			return true;
	}
	return false;
}

#else
bool sendEspCmd(const char* cmd, char* response, int wait_time = 500)
{
	Serial1.println(cmd);
	delay(wait_time);
	while (Serial1.available() > 0)
	{
		Serial.write(Serial1.read());
	}

	return true;

}

bool sendEspCmdNoNL(uint8_t* cmd, size_t size, char* response, int wait_time = 500)
{
	Serial1.write(cmd, size);
	delay(wait_time);

	while (Serial1.available() > 0)
	{
		if (Serial1.find(response))
			return true;
	}
	Serial.println("No response found!");
	return false;

}

bool sendEspCmd(unsigned int cmd, char* response, int wait_time = 500)
{
	Serial1.println(cmd);
	delay(wait_time);
	while (Serial1.available() > 0)
	{
		Serial.write(Serial1.read());
	}
	return false;
}
#endif


void sendEspCmdNoNL(char* cmd)
{
	Serial1.print(cmd);
}