function DirLight(gl, direction, ambient, diffuse, specular) {
    this.type = Object.freeze({DIRECTIONAL : 1, POINT : 2, SPOTLIGHT : 3});
    this.gl = gl;
    this.direction = vec3.create();
    vec3.normalize(this.direction, direction);
    this.ambient = ambient;
    this.diffuse = diffuse;
    this.specular = specular;

    this.uAmbient = null;
    this.uDiffuse = null;
    this.uDirection = null;
    this.uSpecular = null;
}

DirLight.prototype.setAmbient = function(amb)
{
    this.ambient = amb;
}

DirLight.prototype.setUniformLocations = function(dir, amb, dif, spec) {
    this.uDirection = dir;
    this.uAmbient = amb;
    this.uDiffuse = dif;
    this.uSpecular = spec;
}

DirLight.prototype.setUniforms = function() {
    gl.uniform3fv(this.uDirection, this.direction);
    gl.uniform3fv(this.uAmbient, this.ambient);
    gl.uniform3fv(this.uDiffuse, this.diffuse);
    gl.uniform3fv(this.uSpecular, this.specular);
}