#ifndef _VIEWMANAGER_H_
#define _VIEWMANAGER_H_

#include "AssertImpl.h"
#include "View.h"

class ViewManager
{
public:
	static void SetCurrentView(uint8_t ViewId)
	{
		assert(ViewId < NumberViews);

		if(CurrentView != nullptr)
			CurrentView->OnDeactivateView();

		CurrentView = RegisteredViews[ViewId];
		CurrentView->OnActivateView();
	}

	static View* GetCurrentView()
	{
		assert(CurrentView != nullptr);

		return CurrentView;
	}

	static uint8_t RegisterView(View* ViewObj)
	{
		assert(NumberViews >= 0 && NumberViews < 16);
		RegisteredViews[NumberViews] = ViewObj;

		return NumberViews++;
	}

	static void RegisterView(View* ViewObj, uint8_t ViewId)
	{
		assert(ViewId <= NumberViews);
		assert(NumberViews >= 0 && NumberViews < 16);

		RegisteredViews[ViewId] = ViewObj;
		NumberViews++;
	}

private:
	static View* CurrentView;
	static View* RegisteredViews[16];

	static uint8_t NumberViews;
};

View* ViewManager::CurrentView = nullptr;
View* ViewManager::RegisteredViews[] = { nullptr };
uint8_t ViewManager::NumberViews = 0;

#endif // _VIEWMANAGER_H
