#include "AssertImpl.h"
#include <Arduino.h>

void __assert(const char *__func, const char *__file, int __lineno, const char *__sexp)
{
	Serial.println(__func);
	Serial.println(__file);
	Serial.println(__lineno, DEC);
	Serial.println(__sexp);
	Serial.flush();
	abort();
}