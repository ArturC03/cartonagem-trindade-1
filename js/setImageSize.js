document.addEventListener('DOMContentLoaded', function() {
    var svgElement = document.querySelector('svg');
    if (svgElement) {
        var svgWidth = svgElement.width.baseVal.value;
        var svgHeight = svgElement.height.baseVal.value;
        document.getElementById('size_x').value = svgWidth;
        document.getElementById('size_y').value = svgHeight;
    }
});