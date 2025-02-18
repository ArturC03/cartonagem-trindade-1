document.addEventListener('DOMContentLoaded', function() {
    var svgElement = document.querySelector('svg');
    if (svgElement) {
        var svgWidth = svgElement.clientWidth;
        var svgHeight = svgElement.clientHeight;
        document.getElementById('size_x').value = svgWidth;
        document.getElementById('size_y').value = svgHeight;
    }
});