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
    
//         numBoxes = 0;
//        $(".scrollContainer .item").each(function() {
//             numBoxes++;
//        });
    
    var numBoxes = 10;
    var foreverWidth = parseInt($(".list").css("width"));
     $(".rightClick").click(function() {
        var containerWidth = parseInt($(".scrollContainer").css("width"));
        console.log(foreverWidth, containerWidth, numBoxes, -(foreverWidth+containerWidth),
                    parseInt($(".scrollContainer").css("left")),
                   parseInt($(".scrollContainer").css("left")) > -(foreverWidth+containerWidth));
        if (parseInt($(".scrollContainer").css("left")) > -(foreverWidth+containerWidth)) {
            $(".scrollContainer").css("left", "-="+foreverWidth/(numBoxes/4)+"px");
        }
     });
    $(".leftClick").click(function() {
        if (parseInt($(".scrollContainer").css("left")) < 0) {
            $(".scrollContainer").css("left", "+="+foreverWidth/(numBoxes/4)+"px");
        }
     });
});