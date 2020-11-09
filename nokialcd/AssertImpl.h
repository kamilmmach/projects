#ifndef _ASSERTIMPL_H_
#define _ASSERTIMPL_H_

#define __ASSERT_USE_STDERR
#include <assert.h>

// Assert to serial for debugging purposes
void __assert(const char *__func, const char *__file, int __lineno, const char *__sexp);

#endif