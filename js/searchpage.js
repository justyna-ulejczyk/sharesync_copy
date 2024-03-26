document.addEventListener('DOMContentLoaded', function () {
    // Get all elements with the class "group"
    const groupElements = document.querySelectorAll('.group');

    // Add event listeners to each "group" element
    groupElements.forEach(groupElement => {
        groupElement.addEventListener('mouseenter', () => {
            // Add the "active" class when the mouse enters
            groupElement.classList.add('active');
        });

        groupElement.addEventListener('mouseleave', () => {
            // Remove the "active" class when the mouse leaves
            groupElement.classList.remove('active');
        });
    });
});
document.getElementById('photoInput').addEventListener('change', function (event) {
    const [file] = event.target.files;
    if (file) {
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});


function exitButton(clickedElement) {
    var dimmedElement = document.querySelector('.dimmed');
    var postElement = clickedElement.closest('.posts');

    dimmedElement.classList.remove('active');

    console.log('Clicked Element:', clickedElement);
    console.log('Post Element:', postElement);

    if (postElement) {
        var postId = postElement.getAttribute('data-postid');

        console.log('Opened post with ID:', postId);

        var postPreElement = postElement.querySelector('prepost');

        if (postPreElement) {
            postPreElement.style.display = 'none';
        }
    } else {
        console.log('No post element found.');
    }
}

function postComment(postid, username) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/comments.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    var text = document.getElementById("comment-create-text-" + postid).value;
    document.getElementById("comment-create-text-" + postid).value = "";

    // Get current date
    var currentDate = new Date();

    // Extract year, month, and day
    var year = currentDate.getFullYear();
    var month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Months are zero-based
    var day = String(currentDate.getDate()).padStart(2, '0');

    // Construct the date string in the format YYYY-MM-DD
    var formattedDate = `${year}-${month}-${day}`;

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                commentid = xhr.responseText
                var commentContainer = document.getElementsByClassName("comment-container id-" + postid)[0];
                if (commentContainer.textContent.trim() == "No comments") {
                    commentContainer.textContent = "";
                }
                var newCommentTop = document.createElement("div");
                newCommentTop.classList.add("comment-user-comment");
                newCommentTop.innerHTML = `<div class='user-container'>
                <a href='Profile.php?id=${username}'><img src='../images/icons/Unknown_person.jpg' class='post-avatar' /></a>
                <div class='user-post-name'>
                    <span>${username}</span>
                    <span>Comment - ${formattedDate}</span>
                </div>
            </div>
            </button>`
                var newCommentBottom = document.createElement("div");
                newCommentBottom.innerHTML = `<div>
                <div class='comment-text'>${text}</div>
                <div class='comment-options'>
       
                <form action='../php/deleteComments.php' method='post'>
                <input type='hidden' name='comment_id' value='${commentid}'>
                <button type='submit' name='delete_comment'>Delete</button>
                </form>
                </div>
            </div>`
                commentContainer.appendChild(newCommentTop);
                commentContainer.appendChild(newCommentBottom);
            } else {
                console.error('Error:', xhr.statusText);
            }
        }
    };

    xhr.onerror = function () {
        console.error('Request failed');
    };

    xhr.send(JSON.stringify({
        "postid": postid,
        "text": text
    }));
}
