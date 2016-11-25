//when the HTML is loaded, load/run everything in the function
$(document).ready(function () {
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

    //global defined color to change the text to when the input is wrong
    var invalidColor = "#ca616d";

    /*
    Function Name: changeColor
    Input: 
        tag: The id or class of the content being selected
        re:  The regular expression to match it against
    
    Output: A true or false statement that the contents passed or failed the regex
    Effect: The content that doesn't pass the regex is colored, otherwise, the text is reset to white
    */
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
        return re.test(contents);
    }
    
    //global definition of a variable for each form feild
    var userNamePass, emailPass, passwordPass;
    //set this all to false
    userNamePass = passwordPass = emailPass = false;
    
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
        //if the element passes the regex or if the content is empty
        if (changeColor(tag, re) === true || $(tag).val() === "") {
            //clear the error string
            $(locationId).empty();
        } else {
            //add in the error log if the content does not pass the regex
            $(locationId).html(failString);
        }
        return changeColor(tag, re);
    }

    //when someone presses a key while focused on the username feild
    $("#userName").keyup(function () {
        var errorString = "Username can only contain letters, numbers and special characters . - _";
        userNamePass = errorLog("#userName", /^[A-z\-_0-9]*$/, "#userNameError", errorString);
    });

    $("#email").change(function () {
        var re = /^[A-z\.\-_]+@[A-z\.\-_]+\b(\.com|\.edu|\.gov)\b$/;
        var contents = $("#email").val();
        if (re.test(contents) === true) {
            $("#emailError").empty();
            emailPass = true;
        }
        else if (contents === "") {
            emailPass = false;
        }
        else {
            
        }
        emailPass = errorLog("#email", re, "#emailError", "Only .com .edu .gov accounts ok");
    });
    
    $("#password").change(function() {
        var re = /^.{7,}$/
        var contents = $("#password").val();
        if (re.test(contents) === true) {
            $("#passwordError").empty();
        }
        else if (contents === "") {
            passwordPass = false;
        } 
        else {
            $("#passwordError").html("Password must be longer than 8 characters");
            passwordPass = false;
        }
    });
    
    $("#confirmPassword").change(function () {
        var pass1 = $("#password").val();
        var pass2 = $("#confirmPassword").val();
        if (pass1 !== pass2) {
            $("#confirmPassword").css("color", invalidColor);
            $("#confirmPasswordError").html("Passwords do not match");
            passwordPass = false;
        } else {
            $("#confirmPassword").css("color", "white");
            $("#confirmPasswordError").empty();
            if (pass1 !== "" && pass2 !== "") {
                passwordPass = true;
            }
        }
    });
    
    $("#userName, #confirmPassword, #password, #email").change(function() {
        if (userNamePass === true && passwordPass === true && emailPass === true) {
            $("#submit").css("background", "rgba(25, 123, 255, 0.53)");
            $("#submit").removeAttr("disabled");
        } else {
            $("#submit").css("background", "grey");
            $("#submit").attr("disabled", "disabled");  
        }
    });
});