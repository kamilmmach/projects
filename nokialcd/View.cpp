#include "View.h"
#include "Encoder.h"

void View::AddComponent(Component* c)
{
	Components[NumComponents++] = c;
}

void View::Update()
{
	if (Encoder::instance().IsRotatingCW())
	{
		if (SelectedComponent >= 0 && Components[SelectedComponent]->bIsSelected)
		{
			Components[SelectedComponent]->OnUp();
		}
		else
		{
			for (int8_t i = SelectedComponent + 1; i < NumComponents; ++i)
			{
				if (!Components[i]->bIsFocusable)
					continue;

				if (SelectedComponent >= 0)
					Components[SelectedComponent]->bIsFocused = false;
				SelectedComponent = i;
				Components[i]->bIsFocused = true;
				break;
			}
		}
	}
	else if (Encoder::instance().IsRotatingCCW())
	{
		if (SelectedComponent >= 0 && Components[SelectedComponent]->bIsSelected)
		{
			Components[SelectedComponent]->OnDown();
		}
		else
		{
			for (int8_t i = SelectedComponent - 1; i >= 0; --i)
			{
				if (!Components[i]->bIsFocusable)
					continue;

				if (SelectedComponent >= 0)
					Components[SelectedComponent]->bIsFocused = false;

				SelectedComponent = i;
				Components[i]->bIsFocused = true;
				break;
			}
		}
	}

	if (Encoder::instance().IsButtonPressed())
	{
		if (SelectedComponent >= 0)
		{
			if (Components[SelectedComponent]->bIsSelectable)
				Components[SelectedComponent]->bIsSelected = !Components[SelectedComponent]->bIsSelected;

			Components[SelectedComponent]->OnClick();
		}
	}

	for (uint8_t i = 0; i < NumComponents; ++i)
	{
		Components[i]->Update();
	}
}

void View::Draw(Adafruit_PCD8544* display) const
{
	for (uint8_t i = 0; i < NumComponents; ++i)
	{
		Components[i]->Draw(display);
	}
}

void View::OnActivateView()
{
	for (uint8_t i = 0; i < NumComponents; ++i)
	{
		Components[i]->OnActivateView();
	}
}

void View::OnDeactivateView()
{
	if (SelectedComponent >= 0)
		Components[SelectedComponent]->bIsFocused = false;

	SelectedComponent = -1;

	for (uint8_t i = 0; i < NumComponents; ++i)
	{
		Components[i]->OnDeactivateView();
	}
}