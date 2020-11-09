#ifndef _PIXEL_H_
#define _PIXEL_H_

class Pixel
{
private:
	float r_;
	float g_;
	float b_;

	float clamp(float value);
public:
	Pixel();
	Pixel(float r, float g, float b);
	Pixel(float intensity);

	float r() const { return r_; }
	float g() const { return g_; }
	float b() const { return b_; }

	void set_r(float r) { r_ = clamp(r); }
	void set_g(float g) { r_ = clamp(g); }
	void set_b(float b) { r_ = clamp(b); }

	void set_color(float r, float g, float b);
	void set_intensity(float intensity);
	void scale_intensity(float scale);
	void add_intensity(float intensity);
};

#endif
