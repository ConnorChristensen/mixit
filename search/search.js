$(document).ready(function() {
    $("form").change(function() {
        var numWantFields = $(".have input").length;
        var numDontWantFields = $(".dontWant input").length;

        console.log(numWantFields, numDontWantFields); 
    });
});