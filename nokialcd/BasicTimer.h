#ifndef _BASICTIMER_H_
#define _BASICTIMER_H_

class BasicTimer
{
public:
	BasicTimer();

	void Reset();
	void Tick();
	unsigned long GetDeltaTime() const;
	unsigned long GetAbsoluteTime() const;

private:
	unsigned long BaseTime;
	unsigned long PreviousTime;
	unsigned long CurrentTime;
	unsigned long DeltaTime;
	
};

#endif // _TIMER_H_
