#ifndef _VIEW_h
#define _VIEW_h

#include <Adafruit_GFX.h>
#include <Adafruit_PCD8544.h>

#include "Component.h"

#define MAX_COMPONENTS 8

class View
{
public:

	/**
	* Adds a component to this view
	* 
	* @param c Component that will be added to this view
	*/
	void AddComponent(Component* c);

	virtual void OnActivateView();
	virtual void OnDeactivateView();

	virtual void Update();
	virtual void Draw(Adafruit_PCD8544* display) const;

private:
    Component* Components[MAX_COMPONENTS];
	uint8_t NumComponents = 0;

	int8_t SelectedComponent = -1;
};

#endif