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
    $(".like").click(function() {
        var drinkName = $(this).parent().find("h2").eq(0).html(); 
        $.ajax({
            type: "POST",
            url: "results.php",
            data: {this: "thing"},
//            data: {
//                bevName: drinkName, 
//                choice: "like"
//            },
            success: function() {
                $(this).addClass("selected"); 
                $(this).removeClass("unselected");
//                window.location.reload();
                console.log(drinkName);
            }
        });
    });
});


//var elem = document.createElement('textarea');
//elem.innerHTML = encoded;
//var decoded = elem.value;