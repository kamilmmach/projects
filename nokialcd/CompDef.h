#ifndef _COMPDEF_h
#define _COMPDEF_h

#include "Component.h"

class LabelComponent : public Component
{
public:

	LabelComponent(char* v)
		: Text(v)
	{
		bIsFocusable = false;
	}

	char* Text;

	virtual void Draw(Adafruit_PCD8544* display) const override;

private:

};

class ButtonComponent : public Component
{
public:

	ButtonComponent(char* v)
		: Text(v)
	{
		bIsFocusable = true;
	}

	virtual void OnClick() override
	{
		if (OnClickCallback != nullptr)
			OnClickCallback();
	}

	void SetOnClickCallback(void(*c)())
	{
		OnClickCallback = c;
	}

	virtual void Draw(Adafruit_PCD8544* display) const override;

protected:
	char* Text;

private:
	void(*OnClickCallback)() = nullptr;
};

class CheckboxComponent : public ButtonComponent
{
public:

	CheckboxComponent(char* v)
		: ButtonComponent(v), Checked(false)
	{
		bIsFocusable = true;
	}

	void OnClick() override
	{
		Checked = !Checked;
		
		ButtonComponent::OnClick();
	}


	void SetChecked(bool IsChecked)
	{
		Checked = IsChecked;
	}

	void Draw(Adafruit_PCD8544* display) const override;

private:
	bool Checked;
};

#endif

