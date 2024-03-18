function toggleDropdownNav() {
    var dropdownContent = document.getElementById("dropdownContent");
    dropdownContent.classList.toggle("active");

    // Select all items in the dropdown
    var items = dropdownContent.querySelectorAll(".dropdown-item");

    // Loop through each item
    for (var i = 0; i < items.length; i++) {
        // Show the first 3 items, hide the rest
        if (i < 3) {
            items[i].style.display = "block";
        } else {
            items[i].style.display = "none";
        }
    }
}

function toggleDropdownProfile() {
    var dropdownContent = document.getElementById("dropdownContentProfile");
    dropdownContent.classList.toggle("active");
}


function toggleHeart(postid) {
    postidnum = String(postid);
    var icons = document.querySelectorAll(".like.icons.post-" + postid);
    icons.forEach(element => {
        element.classList.toggle("active");
    });
}



function openPost(clickedElement) {
    var postElement = clickedElement.closest('.posts');

    console.log('Clicked Element:', clickedElement);
    console.log('Post Element:', postElement);

    if (postElement) {
        var postId = postElement.getAttribute('data-postid');
        var postPreElement = postElement.querySelector('prepost');

        if (postPreElement) {
            postPreElement.style.display = 'flex';
        }

        var dimmedElement = document.querySelector('.dimmed');
        if (dimmedElement) {
            dimmedElement.classList.add('active');
        }
    } else {
        console.log('No post element found.');
    }
}



function toggleMore() {
    var dots = document.getElementById("dots");
    var moreText = document.getElementById("more");
    var btnText = document.getElementById("myBtn");

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        btnText.innerHTML = "Read more";
        moreText.style.display = "none";
    } else {
        dots.style.display = "none";
        btnText.innerHTML = "Read less";
        moreText.style.display = "inline";
    }
}

function hasClass(element, className) {
    return (' ' + element.className + ' ').indexOf(' ' + className + ' ') > -1;
}


function handleLikeButtonClick(postid) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/update_likes.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                var counters = document.getElementsByClassName('likeCounter ' + postid)
                for (let counter of counters) {
                    counter.innerHTML = response.likesCount;
                };
            } else {
                console.error('Error:', xhr.statusText);
            }
        }
    };

    xhr.onerror = function () {
        console.error('Request failed');
    };

    xhr.send(JSON.stringify({
        postid: postid
    }));
}

function handleSubmit(buttonId, formId, messageId) {
    var messageInput = document.getElementById(messageId);
    if (messageInput.value.trim() === "") {
        alert("Please enter a message.");
        return;
    } else {
        // Disable the button to prevent multiple submissions
        document.getElementById(buttonId).disabled = true;

        // Submit the form
        document.getElementById(formId).submit();
    }


}




