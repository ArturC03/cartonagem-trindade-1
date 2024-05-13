// var elem = document.documentElement;
// var isFullscreen = localStorage.getItem('fullscreen') === 'true';

// if (isFullscreen) {
//     if (elem.requestFullscreen) {
//         elem.requestFullscreen();
//     } else if (elem.webkitRequestFullscreen) {
//         elem.webkitRequestFullscreen();
//     } else if (elem.msRequestFullscreen) {
//         elem.msRequestFullscreen();
//     }
// } else {
//     if (document.exitFullscreen) {
//         document.exitFullscreen();
//     } else if (document.webkitExitFullscreen) {
//         document.webkitExitFullscreen();
//     } else if (document.msExitFullscreen) {
//         document.msExitFullscreen();
//     }
// }

// function toggleFullscreen() {
//     if (document.fullscreenElement || document.webkitFullscreenElement || document.msFullscreenElement) {
//         if (document.exitFullscreen) {
//             document.exitFullscreen();
//         } else if (document.webkitExitFullscreen) {
//             document.webkitExitFullscreen();
//         } else if (document.msExitFullscreen) {
//             document.msExitFullscreen();
//         }
//     } else {
//         if (elem.requestFullscreen) {
//             elem.requestFullscreen();
//         } else if (elem.webkitRequestFullscreen) {
//             elem.webkitRequestFullscreen();
//         } else if (elem.msRequestFullscreen) {
//             elem.msRequestFullscreen();
//         }
//     }
// }

$(document).ready(function() {
    // var fullscreen = document.documentElement;
    // var isFullscreen = localStorage.getItem('fullscreen') === 'true';

    // if (isFullscreen) {
    //     if (fullscreen.requestFullscreen) {
    //         fullscreen.requestFullscreen();
    //     } else if (fullscreen.webkitRequestFullscreen) {
    //         fullscreen.webkitRequestFullscreen();
    //     } else if (fullscreen.msRequestFullscreen) {
    //         fullscreen.msRequestFullscreen();
    //     }
    // } else {
    //     if (document.exitFullscreen) {
    //         document.exitFullscreen();
    //     } else if (document.webkitExitFullscreen) {
    //         document.webkitExitFullscreen();
    //     } else if (document.msExitFullscreen) {
    //         document.msExitFullscreen();
    //     }
    // }

    var theme = $('#theme');
    var isDark = localStorage.getItem('theme');
    console.log(isDark);
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