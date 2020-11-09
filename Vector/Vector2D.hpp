#pragma once

#include <cmath>
#include <cstdint>
#include <algorithm>

#include <MathUtility.hpp>

struct Vector2D
{
	float X;

	float Y;

public:

	static const Vector2D ZeroVector;

	static const Vector2D UnitVector;


public:
	inline Vector2D() { }

	inline Vector2D(float InX, float InY);

public:
	inline Vector2D operator+(const Vector2D& V) const;

	inline Vector2D operator-(const Vector2D& V) const;

	inline Vector2D operator*(const Vector2D& V) const;

	inline Vector2D operator/(const Vector2D& V) const;

	inline Vector2D operator+(float A) const;

	inline Vector2D operator-(float A) const;

	inline Vector2D operator*(float Scale) const;

	inline Vector2D operator/(float Scale) const;

public:
	// Boolean operators

	inline bool operator==(const Vector2D& V) const;

	inline bool operator!=(const Vector2D& V) const;

	inline bool Equals(const Vector2D& V, float Tolerance = KINDA_SMALL_NUMBER) const;

	inline Vector2D operator-() const;

	inline Vector2D operator+=(const Vector2D& V);

	inline Vector2D operator-=(const Vector2D& V);

	inline Vector2D operator*=(const Vector2D& V);

	inline Vector2D operator/=(const Vector2D& V);

	inline Vector2D operator+=(float A);

	inline Vector2D operator-=(float A);

	inline Vector2D operator*=(float Scale);

	inline Vector2D operator/=(float Scale);

	inline float operator[](int32_t Index) const;

	inline float& operator[](int32_t Index);

public:

	inline static float DotProduct(const Vector2D& A, const Vector2D& B);

	inline void Set(float InX, float InY);

	inline float GetMax() const;

	inline float GetMin() const;

	inline float GetAbsMax() const;

	inline float GetAbsMin() const;

	inline float Length() const;

	inline float LengthSquared() const;

	inline void Normalize(float Tolerance = SMALL_NUMBER);
};

inline Vector2D operator*(float Scale, const Vector2D& V)
{
	return V * Scale;
}

inline Vector2D::Vector2D(float InX, float InY)
	: X(InX), Y(InY)
{}

inline Vector2D Vector2D::operator+(const Vector2D& V) const
{
	return Vector2D(X + V.X, Y + V.Y);
}

inline Vector2D Vector2D::operator-(const Vector2D& V) const
{
	return Vector2D(X - V.X, Y - V.Y);
}

inline Vector2D Vector2D::operator*(const Vector2D& V) const
{
	return Vector2D(X * V.X, Y * V.Y);
}

inline Vector2D Vector2D::operator/(const Vector2D& V) const
{
	return Vector2D(X / V.X, Y / V.Y);
}

inline Vector2D Vector2D::operator+(float A) const
{
	return Vector2D(X + A, Y + A);
}

inline Vector2D Vector2D::operator-(float A) const
{
	return Vector2D(X - A, Y - A);
}

inline Vector2D Vector2D::operator*(float Scale) const
{
	return Vector2D(X * Scale, Y * Scale);
}

inline Vector2D Vector2D::operator/(float Scale) const
{
	const float RScale = 1.0f / Scale;
	return Vector2D(X * RScale, Y * RScale); 
}

inline bool Vector2D::operator==(const Vector2D& V) const
{
	return X == V.X && Y == V.Y;
}

inline bool Vector2D::operator!=(const Vector2D& V) const
{
	return X != V.X || Y != V.Y;
}

inline bool Equals(const Vector2D& V, float Tolerance = KINDA_SMALL_NUMBER) const
{
	return std::abs(X - V.X) <= Tolerance && std::abs(Y - V.Y) <= Tolerance;
}

inline Vector2D Vector2D::operator-() const
{
	return Vector2D(-X, -Y);
}

inline Vector2D Vector2D::operator+=(const Vector2D& V)
{
	X += V.X;
	Y += V.Y;
	return *this;
}

inline Vector2D Vector2D::operator-=(const Vector2D& V)
{
	X -= V.X;
	Y -= V.Y;
	return *this;
}

inline Vector2D Vector2D::operator*=(const Vector2D& V)
{
	X *= V.X;
	Y *= V.Y;
	return *this;
}

inline Vector2D Vector2D::operator/=(const Vector2D& V)
{
	X /= V.X;
	Y /= V.Y;
	return *this;
}

inline Vector2D Vector2D::operator+=(float A)
{
	X += A;
	Y += A;
	return *this;
}

inline Vector2D Vector2D::operator-=(float A)
{
	X -= A;
	Y -= A;
	return *this;
}

inline Vector2D Vector2D::operator*=(float Scale)
{
	X *= Scale;
	Y *= Scale;
	return *this;
}

inline Vector2D Vector2D::operator/=(float Scale)
{
	const float RScale = 1.0f / Scale;
	X *= RScale;
	Y *= RScale;
	return *this;
}

inline float Vector2D::operator[](int32_t Index) const
{
	return ((Index == 0) ? X : Y);
}

inline float& Vector2D::operator[](int32_t Index)
{
	return ((Index == 0) ? X : Y);
}

inline static float Vector2D::DotProduct(const Vector2D& A, const Vector2D& B)
{
	return A.X * B.X + A.Y * B.Y;
}

inline void Vector2D::Set(float InX, float InY)
{
	X = InX;
	Y = InY;
}

inline float Vector2D::GetMax() const
{
	return std::max(X, Y);
}

inline float Vector2D::GetMin() const
{
	return std::min(X, Y);
}

inline float Vector2D::GetAbsMax() const
{
	return std::max(std::abs(X), std::abs(Y));
}

inline float Vector2D::GetAbsMin() const
{
	return std::min(std::abs(X), std::abs(Y));
}

inline float Vector2D::Length() const
{
	return std::sqrt(X * X + Y * Y);
}

inline float Vector2D::LengthSquared() const
{
	return X * X + Y * Y;
}

inline void Vector2D::Normalize(float Tolerance = SMALL_NUMBER)
{
	const float SquareSum = X*X + Y*Y;
	if(SquareSum > Tolerance)
	{
		const float Scale = 1.0f / std::sqrt(SquareSum);
		X *= Scale;
		Y *= Scale;
		return ;
	}
	X = 0.0f;
	Y = 0.0f;
}
