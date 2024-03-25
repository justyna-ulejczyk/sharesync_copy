const imageLoader = document.getElementById('imageLoader');
const canvas = document.getElementById('drawing-board');
const toolbar = document.getElementById('toolbar');
const ctx = canvas.getContext('2d');
let undoStack = [];
let redoStack = [];



// Remove style width and height assignments; directly set canvas size.
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
canvas.style.backgroundColor = 'white';

canvas.width = 800;
canvas.height = 600;

let isPainting = false;
let lineWidth = 5;

// This function adjusts mouse coordinates properly considering the element's bounding box.
function getMousePosition(event) {
    const rect = canvas.getBoundingClientRect();

    // Scale mouse coordinates after they have been adjusted to be relative to the element
    const scaleX = canvas.width / rect.width;    
    const scaleY = canvas.height / rect.height;

    return {
        x: (event.clientX - rect.left) * scaleX,
        y: (event.clientY - rect.top) * scaleY
    };
}

toolbar.addEventListener('click', e => {
    if (e.target.id === 'clear') {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }
});

toolbar.addEventListener('change', e => {
    if (e.target.id === 'stroke') {
        ctx.strokeStyle = e.target.value;
    }
    
    if (e.target.id === 'lineWidth') {
        lineWidth = e.target.value;
    }
});

canvas.addEventListener('mousedown', (e) => {
    isPainting = true;
    const position = getMousePosition(e);
    ctx.beginPath();
    ctx.moveTo(position.x, position.y);
});

canvas.addEventListener('mousemove', (e) => {
    if (!isPainting) {
        return;
    }
    const position = getMousePosition(e);
    ctx.lineWidth = lineWidth;
    ctx.lineCap = 'round';
    ctx.lineTo(position.x, position.y);
    ctx.stroke();
});

canvas.addEventListener('mouseup', () => {
    isPainting = false;
});

document.getElementById('export').addEventListener('click', () => {
    const dataURL = canvas.toDataURL('image/png');
    const link = document.createElement('a');
    link.href = dataURL;
    link.download = 'canvas-image.png';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
});

document.getElementById('save').addEventListener('click', function() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/save_canvas.php", true);
    var split = this.getAttribute("split");
    var groupid = this.getAttribute("groupid");
    var filename = this.getAttribute("filename");
    const image = canvas.toDataURL('image/png');
    var formData = new FormData();
    formData.append('image', image);
    formData.append("filename", filename);
    formData.append("groupid", groupid);
    formData.append("split", split);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText == "success") {
                console.log("file saved");
            } else {
                console.log(xhr.responseText);
            }
        }
    };
    xhr.send(formData);
});

imageLoader.addEventListener('change', handleImage, false);

function handleImage(e) {
    const reader = new FileReader();
    reader.onload = function(event) {
        const img = new Image();
        img.onload = function() {
            // Clear any existing content
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw the new image
            const scale = Math.min(canvas.width / img.width, canvas.height / img.height);
            const x = (canvas.width / 2) - (img.width / 2) * scale;
            const y = (canvas.height / 2) - (img.height / 2) * scale;
            ctx.drawImage(img, x, y, img.width * scale, img.height * scale);

            // Now the image is the background, any new drawing will be on top
        }
        img.src = event.target.result;
    }
    reader.readAsDataURL(e.target.files[0]);
}

function saveState() {
    undoStack.push(canvas.toDataURL());
    // Clear the redo stack whenever a new action is taken
    redoStack = [];
}

function undoLastAction() {
    if (undoStack.length === 0) return;

    // Pop the latest state and push it into the redo stack
    const prevState = undoStack.pop();
    redoStack.push(canvas.toDataURL());

    // Clear canvas and load the previous state
    const img = new Image();
    img.onload = function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
    };
    img.src = prevState;
}


function redoLastAction() {
    if (redoStack.length === 0) return;

    // Pop the latest state from the redo stack and push the current state into the undo stack
    const nextState = redoStack.pop();
    undoStack.push(canvas.toDataURL());

    // Clear canvas and load the next state
    const img = new Image();
    img.onload = function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
    };
    img.src = nextState;
}


document.getElementById('undo').addEventListener('click', undoLastAction);
document.getElementById('redo').addEventListener('click', redoLastAction);

// Modify your existing event listeners to save state appropriately
canvas.addEventListener('mouseup', () => {
    if (isPainting) {
        isPainting = false;
        saveState();  // Save state on mouse up
    }
});

// Initialize canvas state on load
saveState();