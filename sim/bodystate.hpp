#pragma once

#include <iostream>
#include <glm/vec3.hpp>

class BodyState
{
public:
	BodyState() = default;

	void printPosition2D()
	{
		std::cout << "(" << Position.x << ", " << Position.y << ")\n";
	}

	glm::vec3 Position;
	glm::vec3 Velocity;

};
