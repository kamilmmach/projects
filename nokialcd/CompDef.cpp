#include "CompDef.h"

void LabelComponent::Draw(Adafruit_PCD8544* display) const
{
	display->setTextColor(BLACK, WHITE);
	display->setCursor(X, Y);
	display->print(Text);
}

void ButtonComponent::Draw(Adafruit_PCD8544* display) const
{
	if(bIsFocused)
		display->setTextColor(WHITE, BLACK); 
	else
		display->setTextColor(BLACK, WHITE);

	display->setCursor(X, Y);
	display->print(Text);
}

void CheckboxComponent::Draw(Adafruit_PCD8544* display) const
{
	if (bIsFocused)
		display->setTextColor(WHITE, BLACK);
	else
		display->setTextColor(BLACK, WHITE);

	display->setCursor(X, Y);
	display->print((Checked ? "v" : "x"));
	display->print(" ");
	display->print(Text);
}