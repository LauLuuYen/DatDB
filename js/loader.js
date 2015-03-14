
function showLoading() {
    console.log("Loading");
    $("#body_overlay").removeClass("conceal");
    $("#body_overlay").html("<div class='whirly'></div>");
}

function hideLoading() {
    console.log("Done Loading");
    $("#body_overlay").addClass("conceal");
    $("#body_overlay").html("");
}

$( document ).ready(function() {
    $("body").append("<div id='body_overlay' class='_overlay conceal'></div>");

});