var Camera = function() {
    this.position = vec3.fromValues(0.0, 1.0, -3.0);
    this.target = vec3.fromValues(0.0, 0.0, 0.0);
    this.up = vec3.fromValues(0.0, 1.0, 0.0);
    this.viewMatrix = mat4.create();
    this.lockTarget = true;
}

Camera.prototype.updateViewMatrix = function() {
    mat4.lookAt(this.viewMatrix, this.position, this.target, this.up);
}

Camera.prototype.rotateAroundTarget = function(angle) {
    vec3.rotateY(this.position, this.position, this.target, angle);
}

Camera.prototype.moveForward = function(step) {
    var forward = vec3.create();
    vec3.normalize(forward, vec3.sub(forward, this.target, this.position));
    vec3.scaleAndAdd(this.position, this.position, forward, step);

    if(!this.lockTarget)
        vec3.scaleAndAdd(this.target, this.target, forward, step);
}

