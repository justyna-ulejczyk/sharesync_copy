function newCanvas(clickedElement){
    var canvasFile = document.getElementById("newCanvasContent")
    
    if(canvasFile.style.display === "flex"){
        canvasFile.style.display = "none";
    }else{
        canvasFile.style.display = "flex";
    }

}

function split(clickedElement){
    var splitContent = document.getElementById("splitOptions")
    if(splitContent.style.display === "flex" ){
        splitContent.style.display = "none";
    } else{
        splitContent.style.display = "flex";
    }

}