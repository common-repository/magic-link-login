document.addEventListener("DOMContentLoaded", function () {
    var magicLoginBtn = jQuery('.amc-magic-login-button a');

    magicLoginBtn.on('click', function(event) {
        event.preventDefault();
        jQuery('#amc-spark-mail-input-wrapper').show();
        jQuery('#amc-spark-mail-input').on('keyup', function(event) {
            if(event.keyCode === 13) {
                event.preventDefault();
                // TODO: submit
                console.log('i would now login user. or try it.... lol');
                var mail = jQuery( this ).val();
                console.log(mail);
            }
        });
    });
});