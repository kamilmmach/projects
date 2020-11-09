#pragma once

#include <cmath>

#include "MathUtility.hpp"

struct Vector3D
{
public:
    float X;
    float Y;
    float Z;

public:
    // STATIC

public:
    /**
     * Constructor initializing all components to a single value
     *
     * @param InValue Value to set all components to.
     */
    explicit inline Vector3D(float InValue);

    /**
     * Constructor using initial values for each component
     *
     * @paran InX X coordinate.
     * @paran InY Y coordinate.
     * @param InZ Z coordinate.
     */
    inline Vector3D(float InX, float InY, float InZ);

    /**
     * Calculate the dot product of two vectors
     *
     * @param A The first vector.
     * @param B The second vector.
     * @return The dot product.
     */
    inline static float DotProduct(const Vector3D& A, const Vector3D& B);

    /**
     * Get the result of component-wise addition of this and another vector.
     *
     * @param V The vector to add to this vector.
     * @return The result of vector addition.
     */
    inline Vector3D operator+(const Vector3D& V) const;

    /**
     * Get the result of component-wise subtraction of this and another vector.
     *
     * @param V The vector to subtract from this vector.
     * @return The result of vector subtraction.
     */
    inline Vector3D operator-(const Vector3D& V) const;

    /**
     * Get the result of adding a scalar to each component of this vector. 
     *
     * @param Bias The value to be added to all components.
     * @return Thre result of addition.
     */
    inline Vector3D operator+(float Bias) const;

    /**
     * Get the result of subtracting a scalar from each component of this vector.
     *
     * @param Bias The value to be added to all components.
     * @return The result of subtraction.
     */
    inline Vector3D operator-(float Bias) const;

    /**
     * Get the result of scaling this vector.
     *
     * @param Scale What to scale each component by.
     * @return The result of scaling.
     */
    inline Vector3D operator*(float Scale) const;

    /**
     * Get the result of dividing this vector by a scalar.
     *
     * @param Scale What to divide each component by.
     * @return The result of division.
     */
    inline Vector3D operator/(float Scale) const;


    // Binary operators
    
    /**
     * Check if another vector is equal to this one.
     *
     * @param V The vector to check against.
     * @return true if the vectors are equal, false otherwise.
     */
    bool operator==(const Vector3D& V) const;

    /**
     * Check if another vector is not equal to this one.
     *
     * @param V The vector to check against.
     * @return true if the vectors are not equal, false otherwise.
     */
    bool operator!=(const Vector3D& V) const;

    /**
     * Check if another vector is equal to this one within certain error limit.
     *
     * @param V The vector to check against.
     * @param Tolerance Error tolerance.
     * @return true if the vectors are equal within tolerance limits, false otherwise.
     */
    bool Equals(const Vector3D& V, float Tolerance = KINDA_SMALL_NUMBER) const;

    /**
     * Get a negated copy of this vector.
     *
     * @return A negated copy of this vector.
     */
    inline Vector3D operator-() const;

public:
    
    /**
     * Set directly the components of this vector.
     *
     * @param InX X coordinate.
     * @param InY Y coordinate.
     * @param InZ Z coordinate.
     */
    void Set(float InX, float InY, float InZ);

    /**
     * Get the length of this vector.
     *
     * @return Length of this vector.
     */
    float Length() const;

    /**
     * Get the squared length of this vector.
     *
     * @return Squared length of this vector.
     */
    float LengthSquared() const;

    /**
     * Normalize this vector if it is larger than a given tolerance. Leaves it unchanged if not.
     *
     * @param Tolerance Minimum squared length of vector for normalization.
     * @return true if the vector was normalized correctly, false otherwise.
     */
    bool Normalize(float Tolerance = SMALL_NUMBER);

    /**
     * Checks wether this vector is normalized.
     *
     * @return true if normalized, false otherwise.
     */
    bool IsNormalized() const;

};

// Vector inline functions

/**
 * Multiplies a vector by a scalar.
 *
 * @param Scale scalar value.
 * @param V Vector to scale.
 * @return Result of multiplication.
 */
inline Vector3D operator*(float Scale, const Vector3D& V)
{
    return V * Scale;
}

inline Vector3D::Vector()
{}

inline Vector3D::Vector3D(float InF)
    : X(InF), Y(InF), Z(InF)
{}

inline Vector3D::Vector3D(float InX, float InY, float InZ)
    : X(InX), Y(InY), Z(InZ)
{}

inline Vector3D Vector3D::operator+(const Vector3D& V) const
{
    return Vector3D(X + V.X, Y + V.Y, Z + V.Z);
}

inline Vector3D Vector3D::operator-(const Vector3D& V) const
{
    return Vector3D(X - V.X, Y - V.Y, Z - V.Z);
}

inline Vector3D Vector3D::operator-(float Bias) const
{
    return Vector3D(X - Bias, Y - Bias, Z - Bias);
}

inline Vector3D Vector3D::operator+(float Bias) const
{
    return Vector3D(X + Bias, Y + Bias, Z + Bias);
}

inline Vector3D Vector3D::operator*(float Scale) const
{
    return Vector3D(X * Scale, Y * Scale, Z * Scale);
}

inline Vector3D Vector3D::operator/(float Scale) const
{
    const float RScale = 1.f/Scale;
    return Vector3D(X * RScale, Y * RScale, Z * RScale);
}

inline bool Vector3D::operator==(const Vector3D& V) const
{
    return X == V.X && Y == V.Y && Z = V.Z;
}

inline bool Vector3D::operator!=(const Vector3D& V) const
{
    return X != V.X || Y != V.Y || Z != V.Z;
}

inline bool Vector3D::Equals(const Vector3D&V, float Tolerance) const
{
    return std::abs(X - V.X) <= Tolerance && std::abs(Y - V.Y) <= Tolerance && std::abs(Z - V.Z) <= Tolerance;
}

inline Vector3D Vector3D::operator-() const
{
    return Vector3D(-X, -Y, -Z);
}

inline void Vector3D::Set(float InX, float InY, float InZ)
{
    X = InX;
    Y = InY;
    Z = InZ;
}

inline float Vector3D::Length() const
{
    return std::sqrt(X*X + Y*Y + Z*Z);
}

inline float Vector3D::LengthSquared() const
{
    return X*X + Y*Y + Z*Z;
}

inline bool Vector3D::Normalize(float Tolerance)
{
    const float SquareSum = X*X + Y*Y + Z*Z;
    if(SquareSum > Tolerance)
    {
        const float Scale = 1.0f / std::sqrt(SquareSum);
        X *= Scale;
        Y *= Scale;
        Z *= Scale;
        return true;
    }
    return false;
}

inline bool Vector3D::IsNormalized(float Tolerance) const 
{
    return std::abs(1.0f - LengthSquared()) < TRESH_VECTOR_NORMALIZED;
}
