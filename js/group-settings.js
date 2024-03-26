$('[name=tab]').each(function (i, d) {
    var p = $(this).prop('checked');
    //   console.log(p);
    if (p) {
        $('article').eq(i)
            .addClass('on');
    }
});

$('[name=tab]').on('change', function () {
    var p = $(this).prop('checked');

    // $(type).index(this) == nth-of-type
    var i = $('[name=tab]').index(this);

    $('article').removeClass('on');
    $('article').eq(i).addClass('on');
});

function updateGroupName(event) {
    event.preventDefault();
    var formData = new FormData(event.target);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/update_group_name.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                if (xhr.responseText.length > 1) {
                    document.getElementById('namechangestatus').innerHTML = "Invalid group name please try again."
                } else {
                    document.getElementById('namechangestatus').innerHTML = "Success!"
                }
            } 
        }
    };

    xhr.onerror = function () {
        console.error('Request failed');
    };

    xhr.send(new URLSearchParams(formData));
}

function addUsers(event) {
    event.preventDefault();
    var formData = new FormData(event.target);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/add_users.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                if (xhr.responseText.length > 5) {
                    document.getElementById('adduserstatus').innerHTML = "Invalid username please try again.";
                } else {
                    document.getElementById('adduserstatus').innerHTML = "Success!";
                }
            } 
        }
    };

    xhr.onerror = function () {
        console.error('Request failed');
    };

    xhr.send(new URLSearchParams(formData));
}