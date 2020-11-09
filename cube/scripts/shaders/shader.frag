#ifdef GL_FRAGMENT_PRECISION_HIGH
    precision highp float;
#else
    precision mediump float;
#endif

varying vec2 outTexCoord;
varying vec3 outNormal;
varying vec3 outEye;

struct DirLight {
    vec3 direction;
    vec3 ambient;
    vec3 diffuse;
    vec3 specular;
};

uniform sampler2D uSampler;
uniform DirLight uDirLight;

void main(void) {
    vec3 lightDir;
    lightDir = normalize(-uDirLight.direction);

    float brightness;
    brightness = max(dot(lightDir, outNormal), 0.0);

    vec3 eye = normalize(outEye);

    vec3 halfVector = normalize(lightDir + eye);

    vec3 spec = uDirLight.specular * pow(max(dot(halfVector, outNormal), 0.0), 32.0);

    vec3 texColor = texture2D(uSampler, outTexCoord).rgb;

    vec3 lightColor = uDirLight.ambient * texColor + brightness * uDirLight.diffuse * texColor + spec;

    gl_FragColor =  vec4(lightColor, 1.0);
}