
function showLoading() {
    $("#body_overlay").show();
    $("#body_overlay").html("<div class='whirly'></div>");
}

function hideLoading() {
    $("#body_overlay").hide();
    $("#body_overlay").html("");
}

$( document ).ready(function() {
    $("body").append("<div id='body_overlay' class='overlay'></div>");
    showLoading();
});