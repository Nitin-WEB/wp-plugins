jQuery(document).ready(function($) {
    let popup = $("#dp-popup");
    $("#dp-country").text(dpData.country);

    // Show after 3 seconds
    setTimeout(function() {
        popup.fadeIn();
    }, 3000);

    $("#dp-close").click(function() {
        popup.fadeOut();
    });
});
