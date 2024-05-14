$(document).ready(function() {
    var theme = $('#theme');
    var isDark = localStorage.getItem('theme');
    if (isDark === "true") {
        theme.prop('checked', true);
    } else {
        theme.prop('checked', false);
    }

    theme.change(function() {
        console.log('----------------');
        if (localStorage.getItem('theme') === "false") {
            console.log('true');
            localStorage.setItem('theme', "true");
        } else {
            console.log('false');
            localStorage.setItem('theme', "false");
        }
    });
});