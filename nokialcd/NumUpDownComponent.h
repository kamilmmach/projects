#ifndef _NUMUPDOWNCOMPONENT_H_
#define _NUMUPDOWNCOMPONENT_H_

// #include "AssertImpl.h"

#include "Component.h"
#include "BasicTimer.h"

class NumUpDownComponent : public Component
{
public:
	NumUpDownComponent(int16_t min, int16_t max)
		: MinValue(min), MaxValue(max), BlinkState(false)
	{
		//assert(min <= max);

		CurrentValue = min;

		bIsFocusable = true;
		bIsSelectable = true;
		bShouldWrapNumbers = true;

		BlinkTimer.Reset();
	}

	void Update() override
	{
		BlinkTimer.Tick();

		if (BlinkTimer.GetAbsoluteTime() >= 750)
		{
			OnTick();
			BlinkTimer.Reset();
		}
	}

	void SetMinValue(int16_t Value)
	{
	//	assert(Value <= MaxValue);
		MinValue = Value;

		if (CurrentValue < MinValue)
			CurrentValue = MinValue;
	}

	void SetMaxValue(int16_t Value)
	{
	//	assert(MinValue <= Value);
		MaxValue = Value;

		if (CurrentValue > MaxValue)
			CurrentValue = MaxValue;
	}

	void OnUp() override
	{
		if (CurrentValue < MaxValue)
			CurrentValue++;
		else if (bShouldWrapNumbers && CurrentValue == MaxValue)
			CurrentValue = MinValue;
	}

	void OnDown() override
	{
		if (CurrentValue > MinValue)
			CurrentValue--;
		else if (bShouldWrapNumbers && CurrentValue == MinValue)
			CurrentValue = MaxValue;
	}

	void OnTick()
	{
		BlinkState = !BlinkState;
	}

	void Draw(Adafruit_PCD8544* display) const override;

private:
	int16_t MinValue;
	int16_t MaxValue;
	int16_t CurrentValue;

	bool BlinkState;
	bool bShouldWrapNumbers;
	BasicTimer BlinkTimer;
	
};
#endif // _NUMUPDOWNCOMPONENT_H_