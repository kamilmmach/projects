#include "Screen.h"

Screen::Screen(int width, int height, int num_tlcs)
{
	width_ = width;
	height_ = height;

	pixels_ = new Pixel*[width * height];

	for (int i = 0; i < width_ * height_; ++i)
	{
		pixels_[i] = new Pixel();
	}

	tlc_data_size_ = num_tlcs * 24;
	tlc_data_ = new byte[tlc_data_size_];

	for (int i = 0; i < tlc_data_size_; ++i)
		tlc_data_[i] = 0;
}

Screen::~Screen()
{
	for (int i = 0; i < width_ * height_; ++i)
	{
		delete pixels_[i];
		pixels_[i] = 0;
	}

	delete[] pixels_;
	pixels_ = 0;

	delete[] tlc_data_;
	tlc_data_ = 0;
}

Pixel* Screen::pixel(int x, int y) const
{
	int cell = y * width_ + x;
	return pixels_[cell];
}

void Screen::set_pixel(int x, int y, float r, float g, float b)
{
	pixel(x, y)->set_color(r, g, b);
}
void Screen::set_pixel(int x, int y, float intensity)
{
	pixel(x, y)->set_intensity(intensity);
}

void Screen::update()
{
	for (int i = 0; i < width_ * height_; ++i)
	{
		setChannel(i * 3, int(pixels_[i]->r() * 4095));
		setChannel(i * 3 + 1, int(pixels_[i]->g() * 4095));
		setChannel(i * 3 + 2, int(pixels_[i]->b() * 4095));
	}
}

void Screen::setChannel(int i, int value)
{
	int startByteNumber = i * 3 / 2;
	if (i & 1)
	{
		tlc_data_[startByteNumber] &= ~0xf0;
		tlc_data_[startByteNumber] |= ((value & 0xf) << 4);
		tlc_data_[startByteNumber + 1] = (value & 0xff0) >> 4;
	}
	else
	{
		tlc_data_[startByteNumber] = value & 0xff;
		tlc_data_[startByteNumber + 1] &= ~0x0f;
		tlc_data_[startByteNumber + 1] |= (value >> 8) & 0xf;
	}
}
