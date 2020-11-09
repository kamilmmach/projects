#ifndef _ENCODER_h_
#define _ENCODER_h_

#include <Arduino.h>

class Encoder
{
public:
	enum class Activity {
		None,
		ButtonPress,
		RotationClockwise,
		RotationAnticlockwise
	};

	static Encoder& instance()
	{
		static Encoder* instance = new Encoder();

		return *instance;
	}

	bool CheckActivity(Activity a);

	bool IsButtonPressed()
	{
		return Encoder::States[0];
	}

	bool IsRotatingCW()
	{
		return Encoder::States[1];
	}

	bool IsRotatingCCW()
	{
		return Encoder::States[2];
	}

	void Update();
	
protected:
	Encoder(uint8_t PA = 8, uint8_t PB = 9, uint8_t PBut = 10)
		: PinA(PA), PinB(PB), PinButton(PBut)
	{
		pinMode(PinA, INPUT);
		pinMode(PinB, INPUT);
		pinMode(PinButton, INPUT);

		LastAValue = digitalRead(PinA);
	}

private:
	/**
	* Stores encoder states:
	* 0 - button press
	* 1 - turn CW
	* 2 - turn CCW
	*/
	bool States[3];

	uint8_t LastAValue;
	short PositionCount = 0;

	uint8_t PinA;
	uint8_t PinB;
	uint8_t PinButton;

};

#endif