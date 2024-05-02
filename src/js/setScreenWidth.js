var screenWidth = window.innerWidth;

$.ajax({
    type: "POST",
    url: "backend/set_screen_width.php",
    data: { screenWidth: screenWidth },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
    }
});