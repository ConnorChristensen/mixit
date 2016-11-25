//when the HTML is loaded, load/run everything in the function
$(document).ready(function () {
    
    //global defined color to change the text to when the input is wrong
    var invalidColor = "#c4182c";
    
    /*
    - For each form element on the page, reset it to make sure there is no left over text
    - This is to fix an issue where when the user refreshes the page, previous input information
    was left, and the page overlayed the tile of the form feild over the contents
    */
    $('form').each(function () {
        this.reset()
    });
    
    //disable the button and set the background to grey
    $("#submit").css("background", "grey");
    $("#submit").attr("disabled", "disabled");  

    //when the user focuses/clicks on a text box
    $(".textBox").focus(function () {
        /*
        - Grab the id of the text box, identify the label for that associated id, and add in the attribute
        is-active and is-completed. 
        - is-active moves the label up and makes it blue.
        - is-completed keeps the label there and makes it grey. 
        */
        $("label[for='" + $(this).attr("id") + "']").addClass("is-active is-completed");
    });

    //When the focus is moved out of the box
    $(".textBox").focusout(function () {
        //if the value of the box is empty
        if ($(this).val() === "") {
            //grab the id of the selected box, target the associated label and remove the is-completed class
            $("label[for='" + $(this).attr("id") + "']").removeClass("is-completed");
        }
        //remove the is active class
        $("label[for='" + $(this).attr("id") + "']").removeClass("is-active");
    });
    
    function changeColor(tag, re) {
        //get the contents of the 
        var contents = $(tag).val();
        //if it doesn't pass the regex
        if (re.test(contents) == false) {
            //set the color to the invalid Color
            $(tag).css("color", invalidColor);
        } else {
            //reset the color to white
            $(tag).css("color", "white");
        }
    }
    
    //global definition of a variable for each form feild
    var userNamePass, emailPass, passwordPass;
    //set this all to false
    userNamePass = passwordPass = false;
    
    /*
    Function Name: errorLog
    Input:
        tag:        The id/class of the content being selected
        re:         The regular expression to match it against
        locationId: The id/class of the content where the resulting error message will be stored
        failString: The string to be displayed on failure
        
    Output: The return value of the changeColor function (see changeColor function)
    Effect: The error string is displayed if the contents fail the regex, the error string is cleared if the
            content passes the regex or if the content is empty
    */
    function errorLog(tag, re, locationId, failString) {
        //get the contents of the input
        var contents = $(tag).val();
        
        //if it doesn't pass the regular expression, then change the color
        changeColor(tag, re);
        
        //if the input is empty
        if (contents === "") {
            //clear the error string
            $(locationId).empty();
            //return false to indicate that it does not pass
            return false;
        } 
        //if the element passes the regex
        else if (re.test(contents) === true) {
            //clear the error string
            $(locationId).empty();
            //return a true value to indicate it passed
            return true;
        }
        else {
            //add in the error log if the content does not pass the regex
            $(locationId).html(failString);
            //return false to indicate that it does not pass
            return false;
        }
    }

    //when someone presses a key while focused on the username feild
    $("#userName").keyup(function () {
        var errorString = "Username can only contain letters, numbers and special characters . - _";
        //make sure the username has any letters, numbers, - or _
        userNamePass = errorLog("#userName", /^[A-z\-_0-9]*$/, "#userNameError", errorString);
    });
    
    //when someone changes the input of the feild and then leaves the feild
    $("#password").keyup(function() {
        if ($("#password").val() !== "") {
            passwordPass = errorLog("#password", /^.+$/, "#passwordError", "");
        }
        else {
            passwordPass = false;
        }
    });
    
    $("#userName, #password").keyup(function() {
        if (userNamePass === true && passwordPass === true) {
            $("#submit").css("background", "rgba(25, 123, 255, 0.53)");
            $("#submit").removeAttr("disabled");
        } else {
            $("#submit").css("background", "grey");
            $("#submit").attr("disabled", "disabled");
        }
    });
});