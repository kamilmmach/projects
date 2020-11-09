#ifndef _SCREEN_H_
#define _SCREEN_H_

#include "Arduino.h"
#include "Pixel.h"

class Screen
{
private:
	int width_;
	int height_;

	Pixel** pixels_;
	byte* tlc_data_;
	int tlc_data_size_;

	void setChannel(int i, int value);

public:
	Screen(int width, int height, int num_tlcs);
	~Screen();

	int width() const { return width_;  }
	int height() const { return height_; }
	void update();

	byte* tlc_data() const { return tlc_data_;  }
	int tlc_data_size() const { return tlc_data_size_; }

	Pixel* pixel(int x, int y) const;
	void set_pixel(int x, int y, float r, float g, float b);
	void set_pixel(int x, int y, float intensity);
};

#endif
