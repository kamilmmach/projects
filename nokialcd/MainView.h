#ifndef _VIEWS_MAINVIEW_H
#define _VIEWS_MAINVIEW_H

#include "View.h"
#include "ViewManager.h"
#include "CompDef.h"
#include "TemperatureComponent.h"
#include "RtcComponent.h"

View MainView;
TemperatureComponent MVTemperature(&Globals::gTempSensors, 0);
LabelComponent MVLabelTemp("T0............");

RtcComponent MVRtc(&Globals::gRtc);

void SetupMainView()
{
	MVLabelTemp.SetCharPosition(0, 5);
	MVTemperature.SetCharPosition(8, 5);
	MVRtc.Init();
	MVRtc.SetPosition(0, 0);

	MainView.AddComponent(&MVLabelTemp);
	MainView.AddComponent(&MVTemperature);
	MainView.AddComponent(&MVRtc);

	ViewManager::RegisterView(&MainView);
}

#endif
