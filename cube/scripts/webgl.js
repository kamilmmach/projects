var gl, shaderProgram;

// Shader uniforms and attributes
var inAttribs = {};
var uProjMatrix, uModelViewMatrix, uSampler;

var projMatrix = mat4.create();
var modelViewMatrix = mat4.create();
var camera = new Camera();

var cubeRotation = mat4.create();
var renderableObjects = [];

var dirLight;

var pressedKeys = {};
var lastUpdateTime;

function start() {
    var canvas = document.getElementById('main-canvas');

    initWebGL(canvas);

    if(!gl) {
        console.log('No WebGL support.');
        return;
    }

    initShaders();
    initObjects();
    initLights();

    gl.viewport(0, 0, gl.viewportWidth, gl.viewportHeight);
    gl.clearColor(0.7804, 0.8275, 0.8745, 1.0);
    gl.enable(gl.DEPTH_TEST);
    gl.enable(gl.CULL_FACE);

    mat4.perspective(projMatrix, 45, gl.viewportWidth/gl.viewportHeight, 0.1, 100.0);

    document.onkeydown = handleKeyDown;
    document.onkeyup = handleKeyUp;
    document.onmousemove = handleMouseMove;

    tick();
}

function tick() {
    requestAnimationFrame(tick);

    var currentTime = Date.now(), delta = 0;
    if(lastUpdateTime) {
        delta = currentTime - lastUpdateTime;
    }
    lastUpdateTime = currentTime;
    
    updateScene(delta / 1000.0);
    drawScene();
}

function initObjects() {
    var cube = new Box(gl, inAttribs, 1.0);
    cube.setTexture("cube.png");
    renderableObjects.push(cube);

    var floor = new Box(gl, inAttribs, 5.0, 0.1, 5.0);
    floor.setTexture("cube.png");
    floor.setPosition(vec3.fromValues(0.0, -0.6, 0.0));
    renderableObjects.push(floor);

}

function updateScene(delta) {  
    if(pressedKeys[65])
        camera.rotateAroundTarget(0.05);
    else if(pressedKeys[68])
        camera.rotateAroundTarget(-0.05);
    
    if(pressedKeys[87])
        camera.moveForward(0.01);
    else if(pressedKeys[83])
        camera.moveForward(-0.01);

    camera.updateViewMatrix();
}

function drawScene() {
    gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);
    gl.uniformMatrix4fv(uProjMatrix, false, projMatrix);
    gl.uniform1i(uSampler, 0);
    dirLight.setUniforms();

    for(var i = 0; i < renderableObjects.length; ++i)
    {
        mat4.multiply(modelViewMatrix, camera.viewMatrix, renderableObjects[i].getModelMatrix());
        gl.uniformMatrix4fv(uModelViewMatrix, false, modelViewMatrix);
        renderableObjects[i].draw();
    }

    //cube.draw();
}

function handleKeyDown(event) {
    pressedKeys[event.keyCode] = true;

}

function handleKeyUp(event) {
    pressedKeys[event.keyCode] = false;
}

function handleMouseMove(event) {

}

function initLights() {
    dirLight = new DirLight(gl, 
        vec3.fromValues(1.0, -1.0, -1.0),  // direction
        vec3.fromValues(0.28, 0.3, 0.332),    // ambient
        vec3.fromValues(1.0, 1.0, 1.0),    // diffuse
        vec3.fromValues(0.1, 0.1, 0.1)     // specular
    );

    dirLight.setUniformLocations(
        gl.getUniformLocation(shaderProgram, "uDirLight.direction"),
        gl.getUniformLocation(shaderProgram, "uDirLight.ambient"),
        gl.getUniformLocation(shaderProgram, "uDirLight.diffuse"),
        gl.getUniformLocation(shaderProgram, "uDirLight.specular")
    );
}

function initShaders() {
    var vertexShader = getShader('shader-vs');
    var fragmentShader = getShader('shader-fs');

    shaderProgram = gl.createProgram();
    gl.attachShader(shaderProgram, vertexShader);
    gl.attachShader(shaderProgram, fragmentShader);
    gl.linkProgram(shaderProgram);

    if(!gl.getProgramParameter(shaderProgram, gl.LINK_STATUS)) {
        console.log('Couldn\'t link program: ' + gl.getProgramInfoLog(shaderProgram));
    }

    gl.useProgram(shaderProgram);

    inAttribs.position = gl.getAttribLocation(shaderProgram, "inPosition");
    gl.enableVertexAttribArray(inAttribs.position);

    inAttribs.texCoord = gl.getAttribLocation(shaderProgram, "inTexCoord");
    gl.enableVertexAttribArray(inAttribs.texCoord);

    inAttribs.normal = gl.getAttribLocation(shaderProgram, "inNormal");
    gl.enableVertexAttribArray(inAttribs.normal);

    uProjMatrix = gl.getUniformLocation(shaderProgram, "uProjMatrix");
    uModelViewMatrix = gl.getUniformLocation(shaderProgram, "uModelViewMatrix");
    uSampler = gl.getUniformLocation(shaderProgram, "uSampler");
}

function getShader(id) {
    var script = document.getElementById(id);

    if(!script) { 
        return null;
    }

    var type = null;

    if(script.type == 'x-shader/x-vertex') {
        type = gl.VERTEX_SHADER;
    }
    else if(script.type == 'x-shader/x-fragment') {
        type = gl.FRAGMENT_SHADER;
    }
    else {
        return null;
    }

    var shader = gl.createShader(type);
    gl.shaderSource(shader, script.text);
    gl.compileShader(shader);

    if(!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
        console.log('Can\'t create ' + script.type + ' shader from ' + shader + ': ' + gl.getShaderInfoLog(shader));
        return null;
    }

    return shader;
}

function initWebGL(canvas) {
    try {
        gl = canvas.getContext("experimental-webgl") || canvas.getContext("webgl");
        gl.viewportWidth = canvas.width;
        gl.viewportHeight = canvas.height;
    } catch(e) {}

    if(!gl) {
        alert('Sorry man, your browser/system doesn\'t support WebGL.');
    }
}