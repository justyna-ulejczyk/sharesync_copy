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



function showPostsTab() {
    var profileTab = document.querySelector('.profile-info-display');
    var aboutTab = document.querySelector('.profile-info-about');

    profileTab.style.display = 'flex'
    aboutTab.style.display = 'none';

}

function showAboutTab() {
    var profileTab = document.querySelector('.profile-info-display');
    var aboutTab = document.querySelector('.profile-info-about');

    profileTab.style.display = 'none'
    aboutTab.style.display = 'block';

}

function hideAllAbout() {
    var overview = document.getElementById("overview");
    var contact = document.getElementById("contact");
    var info = document.getElementById("profileInfo")
    overview.style.display = 'none';
    contact.style.display = 'none';
    info.style.display = 'none'

}

function overview(clickedElement) {
    hideAllAbout();
    var overview = document.getElementById("overview");
    overview.style.display = 'block';
}

function contact(clickedElement) {
    hideAllAbout();
    var contact = document.getElementById("contact");
    contact.style.display = 'block';
}


function profileInfo(clickedElement) {
    hideAllAbout();
    var info = document.getElementById("profileInfo")
    info.style.display = 'block';

}