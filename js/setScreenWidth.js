var screenWidth = window.innerWidth;

$.ajax({
    type: "POST",
    url: "setScreenWidth.php",
    data: { screenWidth: screenWidth },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
    }
});