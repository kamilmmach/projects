#include "Pixel.h"

Pixel::Pixel()
{
	r_ = g_ = b_ = 0.0f;
}

Pixel::Pixel(float r, float g, float b)
{
	set_color(r, g, b);
}

Pixel::Pixel(float intensity)
{
	r_ = g_ = b_ = clamp(intensity);
}

void Pixel::set_color(float r, float g, float b)
{
	r_ = clamp(r);
	g_ = clamp(g);
	b_ = clamp(b);
}

float Pixel::clamp(float value)
{
	if (value > 1.0f)
		value = 1.0f;
	else if (value < 0.0f)
		value = 0.0f;

	return value;
}

void Pixel::set_intensity(float intensity)
{
	r_ = g_ = b_ = clamp(intensity);
}

void Pixel::scale_intensity(float scale)
{
	r_ = clamp(r_ * scale);
	g_ = clamp(g_ * scale);
	b_ = clamp(b_ * scale);
}

void Pixel::add_intensity(float intensity)
{
	r_ = clamp(r_ + intensity);
	g_ = clamp(g_ + intensity);
	b_ = clamp(b_ + intensity);
}
