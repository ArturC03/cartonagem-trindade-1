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