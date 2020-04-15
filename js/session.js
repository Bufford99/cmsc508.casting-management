$(document).ready(function() {
    let session;

    $.ajaxSetup({cache: false});
    $.get('session.php', function(data) {
        session = JSON.parse(data);
        
        if (session.user) {
            $('#loginLink').prop('href', 'logout.php');
            $('#loginLink').prop('innerHTML', 'Logout');
        }
    });
});