#ifndef _COMPONENT_h_
#define _COMPONENT_h_

#include <Adafruit_GFX.h>
#include <Adafruit_PCD8544.h>

class Component
{
public:
	/** Called on every loop cycle */
    virtual void Update() {}

	virtual void Draw(Adafruit_PCD8544* display) const = 0;

	/** Called when the view it belongs to is activated */
	virtual void OnActivateView() {}

	/** Called when the view it belongs to is deactivated */
	virtual void OnDeactivateView() {}

	/** Called when the component is focused and the button is pressed */
	virtual void OnClick() {}

	/** Called when the component is selected and the button is pressed */
	virtual void OnUp() {}

	/** Called when the component is selected and the button is pressed */
	virtual void OnDown() {}

	void SetPosition(uint8_t x, uint8_t y)
	{
		X = x;
		Y = y;
	}

	void SetCharPosition(uint8_t x, uint8_t y)
	{
		X = 6 * x;
		Y = 8 * y;
	}

	/** Component's X location */
	uint8_t X = 0;

	/** Component's Y location */
	uint8_t Y = 0;

	/** Whether this component can be focused on in view */
	bool bIsFocusable = false;

	/** Whether this component is currently focused */
	bool bIsFocused = false;

	/** Whether this component can be selected (clicked) by button pressing when focused */
	bool bIsSelectable = false;

	/** Whether this component is currently focused and selected (clicked) */
	bool bIsSelected = false;


protected:


};

#endif