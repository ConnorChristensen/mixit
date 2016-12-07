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
    
    
    
});