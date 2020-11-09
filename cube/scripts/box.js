var Box = function (gl, attribs, scaleX = 1.0, scaleY = 1.0, scaleZ = 1.0) {
    this.gl = gl;
    this.attribs = attribs;
    this.vertexBuffer = null;
    this.rotation = quat.create();
    this.position = vec3.create();
    this.texture = null;
    this.numVertices = 0;
    {
        this.vertexBuffer = this.gl.createBuffer();
        this.gl.bindBuffer(gl.ARRAY_BUFFER, this.vertexBuffer);
        var nx = scaleX * 0.5;
        var ny = scaleY * 0.5;
        var nz = scaleZ * 0.5;

        // vec3:Position; vec2 TexCoord; vec3 Normal;
        var vertices = [
            // Front face
            -nx,  ny,  nz,  0.0,  0.0,  0.0,  0.0,  1.0,
            -nx, -ny,  nz,  0.0,  1.0,  0.0,  0.0,  1.0,
             nx,  ny,  nz,  1.0,  0.0,  0.0,  0.0,  1.0,
             nx,  ny,  nz,  1.0,  0.0,  0.0,  0.0,  1.0,
            -nx, -ny,  nz,  0.0,  1.0,  0.0,  0.0,  1.0,
             nx, -ny,  nz,  1.0,  1.0,  0.0,  0.0,  1.0,

            // Left face
            -nx,  ny, -nz,  0.0,  0.0, -1.0,  0.0,  0.0,
            -nx, -ny, -nz,  0.0,  1.0, -1.0,  0.0,  0.0,
            -nx,  ny,  nz,  1.0,  0.0, -1.0,  0.0,  0.0,
            -nx,  ny,  nz,  1.0,  0.0, -1.0,  0.0,  0.0,
            -nx, -ny, -nz,  0.0,  1.0, -1.0,  0.0,  0.0,
            -nx, -ny,  nz,  1.0,  1.0, -1.0,  0.0,  0.0,

            // Back face
             nx,  ny, -nz,  0.0,  0.0,  0.0,  0.0, -1.0,
             nx, -ny, -nz,  0.0,  1.0,  0.0,  0.0, -1.0,
            -nx,  ny, -nz,  1.0,  0.0,  0.0,  0.0, -1.0,
            -nx,  ny, -nz,  1.0,  0.0,  0.0,  0.0, -1.0,
             nx, -ny, -nz,  0.0,  1.0,  0.0,  0.0, -1.0,
            -nx, -ny, -nz,  1.0,  1.0,  0.0,  0.0, -1.0,

            // Right face
             nx,  ny,  nz,  0.0,  0.0,  1.0,  0.0,  0.0,
             nx, -ny,  nz,  0.0,  1.0,  1.0,  0.0,  0.0,
             nx,  ny, -nz,  1.0,  0.0,  1.0,  0.0,  0.0,
             nx,  ny, -nz,  1.0,  0.0,  1.0,  0.0,  0.0,
             nx, -ny,  nz,  0.0,  1.0,  1.0,  0.0,  0.0,
             nx, -ny, -nz,  1.0,  1.0,  1.0,  0.0,  0.0,

            // Top face
            -nx,  ny, -nz,  0.0,  0.0,  0.0,  1.0,  0.0,
            -nx,  ny,  nz,  0.0,  1.0,  0.0,  1.0,  0.0,
             nx,  ny, -nz,  1.0,  0.0,  0.0,  1.0,  0.0,
             nx,  ny, -nz,  1.0,  0.0,  0.0,  1.0,  0.0,
            -nx,  ny,  nz,  0.0,  1.0,  0.0,  1.0,  0.0,
             nx,  ny,  nz,  1.0,  1.0,  0.0,  1.0,  0.0,

            // Bottom face
            -nx, -ny,  nz,  0.0,  0.0,  0.0, -1.0,  0.0,
            -nx, -ny, -nz,  0.0,  1.0,  0.0, -1.0,  0.0,
             nx, -ny,  nz,  1.0,  0.0,  0.0, -1.0,  0.0,
             nx, -ny,  nz,  1.0,  0.0,  0.0, -1.0,  0.0,
            -nx, -ny, -nz,  0.0,  1.0,  0.0, -1.0,  0.0,
             nx, -ny, -nz,  1.0,  1.0,  0.0, -1.0,  0.0,
        ]
        this.gl.bufferData(this.gl.ARRAY_BUFFER, new Float32Array(vertices), this.gl.STATIC_DRAW);

        this.numVertices = 36;
    }
}

Box.prototype.setPosition = function(pos)
{
    this.position = pos;
}

Box.prototype.setRotation = function(rot)
{
    this.rotation = rot;
}

Box.prototype.setTexture = function(path) {
    this.texture = this.gl.createTexture();
     
    var textureImage = new Image();
    textureImage.texture = this.texture;
    textureImage.onload = function() {
        gl.bindTexture(gl.TEXTURE_2D, this.texture);
        gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, this);
        gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
        gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR_MIPMAP_NEAREST);
        gl.generateMipmap(gl.TEXTURE_2D);
        gl.bindTexture(gl.TEXTURE_2D, null);
    }

    textureImage.src = path;
}

Box.prototype.update = function(dt) {

}

Box.prototype.draw = function() {
    this.gl.bindBuffer(this.gl.ARRAY_BUFFER, this.vertexBuffer);
    this.gl.vertexAttribPointer(this.attribs.position, 3, this.gl.FLOAT, false, 32, 0);
    this.gl.vertexAttribPointer(this.attribs.texCoord, 2, this.gl.FLOAT, false, 32, 12);
    this.gl.vertexAttribPointer(this.attribs.normal, 3, this.gl.FLOAT, false, 32, 20);

    this.gl.activeTexture(this.gl.TEXTURE0);
    this.gl.bindTexture(this.gl.TEXTURE_2D, this.texture);
    this.gl.drawArrays(this.gl.TRIANGLES, 0, this.numVertices);
}

Box.prototype.getModelMatrix = function() {
    var modelMatrix = mat4.create();
    mat4.fromRotationTranslation(modelMatrix, this.rotation, this.position);
    return modelMatrix;
}