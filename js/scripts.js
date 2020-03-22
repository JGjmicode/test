$(document).ready(function() {
    $('body').on('click', '.add-user', function () {
        $.ajax({
            type: "POST",
            url: "/index.php",
            data: {add_user: true},
            success: function () {
                console.log('success');
                $('.users-container').load('/index.php .users-container .user');
            }
        })
    });
});