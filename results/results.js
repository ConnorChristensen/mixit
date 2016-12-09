function requestLogOut(){
    jQuery.ajax({
        type: "GET",
        url: "results.php",
        data: "call=logOut",
        success: function(){
            window.location.reload();
        }
    });
}

$(document).ready(function() {
    
});