attribute vec3 aPos;

uniform mat4 uModelView;
uniform mat4 uProj;

void main(void) {
    gl_Position = uProj * uModelView * vec4(aPos, 1.0);
}
