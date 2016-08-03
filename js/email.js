function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

var existing_email = getUrlVars()["existing_email"];


if (existing_email === 'true'){

    jQuery( document ).ready(function() {
        jQuery('#existing_email').css('display','block');
    });

}