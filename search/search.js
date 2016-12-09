function addWantField() {
    $(".have").append('<input type="text" name="want[]" placeholder="Drink">');
}
function addDontWantField() {
    $(".dontWant").append('<input type="text" name="dontWant[]" placeholder="Drink">');
}

function removeWantFeild() {
    $(".have input").last().remove();
}

function removeDontWantField() {
    $(".dontWant input").last().remove();
}

$(document).ready(function() {
    var numEmpty = 0;
    $(".have").change(function() {
        numEmpty = 0;
        numWantFields = $(".have input").each(function() {
            if(this.value === "") {
                numEmpty++;  
            }
        });
        if (numEmpty < 2) {
            addWantField();
        }
        else if (numEmpty > 3) {
            removeWantFeild();
        }
    });
    $(".dontWant").change(function() {
        numEmpty = 0;
        numWantFields = $(".dontWant input").each(function() {
            if(this.value === "") {
                numEmpty++;  
            }
        });
        if (numEmpty < 2) {
            addDontWantField();
        }
        else if (numEmpty > 3) {
            removeDontWantField();
        }
    });
    
<<<<<<< Updated upstream
    
    
=======
    //set a var that will contain the number of boxes
    var numBoxes = 10;
    
    //set a var that will contain the length of the list container
    var foreverWidth = parseInt($(".list").css("width"));
    
    $(".rightClick").click(function() {
        //reset numBoxes to zero to get a proper count
//        numBoxes = 0;
        //get the width of the scroll container
        var containerWidth = parseInt($(".scrollContainer").css("width"));
        
        //count the number of items in the container
//        $(this).siblings(".scrollContainer .item").each(function() {
//            numBoxes++;
//        });

        
        if (parseInt($(this).siblings(".scrollContainer").css("left")) > -(foreverWidth+containerWidth)) {
            $(this).siblings(".scrollContainer").css("left", "-="+foreverWidth/(numBoxes/4)+"px");
        } else {
            $(this).siblings(".scrollContainer").css("left", -(numBoxes*100)+"px");
        }
    });
    $(".leftClick").click(function() {
//        numBoxes = 0;
        
        //count the number of items in the container
//        $(this).siblings(".scrollContainer .item").each(function() {
//            numBoxes++;
//        });
        
        if (parseInt($(this).siblings(".scrollContainer").css("left")) < 0) {
            $(this).siblings(".scrollContainer").css("left", "+="+foreverWidth/(numBoxes/4)+"px");
        } else {
            $(this).siblings(".scrollContainer").css("left", "0px");
        }
    });
>>>>>>> Stashed changes
});