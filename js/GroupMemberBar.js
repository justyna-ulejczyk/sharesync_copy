function toggleMemberBar() {
    var rightPanel = document.querySelector('.right-bar');
    var isActive = rightPanel.classList.toggle('active');

    // Save the state to localStorage
    localStorage.setItem('rightPanelState', isActive ? 'active' : '');

}

// Check for previous state when the page loads
document.addEventListener('DOMContentLoaded', function () {
    var rightPanel = document.querySelector('.right-bar');
    var savedState = localStorage.getItem('rightPanelState');

    if (savedState === 'active') {
        rightPanel.classList.add('active');
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const menuButton = document.querySelector(".menu-button");
    const leftBar = document.querySelector(".left-bar");

    menuButton.addEventListener("click", function () {
        leftBar.classList.toggle("active");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const menuButton = document.querySelector(".canvas-menu");
    const toolOptions = document.querySelector(".canvas-options");

    menuButton.addEventListener("click", function () {
        toolOptions.classList.toggle("active");
    });
});
