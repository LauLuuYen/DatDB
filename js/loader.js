
function showSpinner () {
    $("#body_overlay").show();
    $("#body_overlay").html("<div class='loadSpinner'></div>");
}

function hideSpinner() {
    $("#body_overlay").hide();
    $("#body_overlay").html("");
}

$( document ).ready(function() {
    console.log("ready");
};