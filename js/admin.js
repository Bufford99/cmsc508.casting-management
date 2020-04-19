$(document).ready(function () {
    let session;

    $.ajaxSetup({
        cache: false
    });
    $.get('session.php', function (data) {
        session = JSON.parse(data);
        if (session.admin) {
            $('#internal-login').hide();
            $('#create-manager').show();
        } else {
            $('#internal-login').show();
            $('#create-manager').hide();
        }
    });
});