#include <iostream>

#include <glm/glm.hpp>

#include "bodystate.hpp"
#include "plane.hpp"

BodyState Integrate(BodyState current_state, glm::vec3 acceleration, float dt);

int main()
{
	BodyState point;
	point.Position = glm::vec3(0.0f, 20.0f, 0.0f);
	point.Velocity = glm::vec3(2.0f, 0.0f, 0.0f);

	Plane ground;
	ground.Normal = glm::normalize(glm::vec3(1.0f, 1.0f, 0.0f));
	ground.Position = glm::vec3(0.0f);
	int frame = 0;

	float total_time = 0.0f;
	float h = 0.1f;

	while(total_time <= 3.0f)
	{
		point.printPosition2D();
		float dt_rem = h;
		float dt = dt_rem;
		while(dt_rem > 0.0f)
		{
			glm::vec3 acceleration = glm::vec3(0.0f, -10.0f, 0.0f);

			// Point after integrating acceleration and velocity
			BodyState point_aft;
			point_aft = Integrate(point, acceleration, dt);

			// Distances from point before and after integration to ground
			float d_cur = glm::dot((point.Position - ground.Position), ground.Normal);
			float d_aft = glm::dot((point_aft.Position - ground.Position), ground.Normal);

			// Check if collision occured between the point and ground
			if((d_cur > 0.0f && d_aft < 0.0f) || 
					(d_cur < 0.0f && d_aft > 0.0f))
			{
				// Compute when the collision occured
				float f = d_cur / (d_cur - d_aft);
				dt = f * dt;

				// Simulate to the time of collision
				point_aft = Integrate(point, acceleration, dt);

				// Compute the resulting new velocity due to collision
				glm::vec3 v_n, v_t;
				v_n = glm::dot(point_aft.Velocity, ground.Normal) * ground.Normal;
				v_t = point_aft.Velocity - v_n;

				// Include loss of energy after collision.
				// The coefficients are based on the elasticity and friction
				// of colliding elements.
				glm::vec3 v_n_aft, v_t_aft;
				v_n_aft = -0.8f * v_n;
				v_t_aft = (1.0f - 0.2f) * v_t;

				point_aft.Velocity = v_n_aft + v_t_aft;

			}
			dt_rem -= dt;

			point = point_aft;
		}
		frame++;

		total_time = frame * h;
	}
}


BodyState Integrate(BodyState current_state, glm::vec3 acceleration, float dt)
{
	BodyState new_state;
	new_state.Velocity = current_state.Velocity + dt * acceleration;
	new_state.Position = current_state.Position + dt * 0.5f * (current_state.Velocity + new_state.Velocity);

	return new_state;
}

