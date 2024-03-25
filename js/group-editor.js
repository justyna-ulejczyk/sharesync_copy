function formatDoc(cmd, value = null) {
    if (value) {
        document.execCommand(cmd, false, value);
    } else {
        document.execCommand(cmd);
    }
}

function addLink() {
    const url = prompt('Insert url');
    formatDoc('createLink', url);
}


const content = document.getElementById('content');

content.addEventListener('mouseenter', function () {
    const a = content.querySelectorAll('a');
    a.forEach(item => {
        item.addEventListener('mouseenter', function () {
            content.setAttribute('contenteditable', false);
            item.target = '_blank';
        })
        item.addEventListener('mouseleave', function () {
            content.setAttribute('contenteditable', true);
        })
    })
})


const showCode = document.getElementById('show-code');
let active = false;

showCode.addEventListener('click', function () {
    showCode.dataset.active = !active;
    active = !active
    if (active) {
        content.textContent = content.innerHTML;
        content.setAttribute('contenteditable', false);
    } else {
        content.innerHTML = content.textContent;
        content.setAttribute('contenteditable', true);
    }
})



const filename = document.getElementById('filename');


function fileHandle(value, groupid, split) {
    console.log(split);
    if (value === 'new') {
        content.innerHTML = '';
        filename.value = 'untitled';
    } else if (value === 'save') {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../php/save_file.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText == "success") {
                    console.log("file saved");
                } else {
                    console.log(xhr.responseText);
                }
            }
        };
        xhr.send("filename=" + filename.value + "&content=" + content.innerHTML + "&groupid=" + groupid + "&split=" + split);
    } else if (value === 'export') {
        const blob = new Blob([content.innerHTML], { type: 'application/rtf' });

        // Create a link element
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
    
        // Set the filename for the download
        link.download = filename.value;
    
        // Append the link to the document body
        document.body.appendChild(link);
    
        // Trigger a click event on the link to start the download
        link.click();
    
        // Cleanup: remove the link and revoke the Blob URL
        document.body.removeChild(link);
        URL.revokeObjectURL(link.href);
        }
}

function openFolder(filename, groupname) {

}