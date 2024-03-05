const svg = document.querySelector('svg');
const inputX = document.getElementById('location_x');
const inputY = document.getElementById('location_y');
var lastX = document.querySelectorAll('circle').length !== 0 ? document.getElementById('circle').getAttribute('cx') : 0;
var lastY = document.querySelectorAll('circle').length !== 0 ? document.getElementById('circle').getAttribute('cy') : 0;

svg.addEventListener('click', e => {
const { pageX, pageY, currentTarget } = e;
const { left, top } = currentTarget.getBoundingClientRect();
const { scrollX, scrollY } = window;
const x = pageX - left - scrollX;
const y = pageY - top - scrollY;
const diameter = 20;

if (svg.innerHTML.includes(createCircle({ x:lastX, y:lastY }, diameter))) {
    svg.innerHTML = svg.innerHTML.replace(createCircle({ x:lastX, y:lastY }, diameter), '');
}

svg.innerHTML += createCircle({ x, y }, diameter);

lastX = x;
lastY = y;
});

function createCircle(center, diameter) {
    const color = "FF5733";

    inputX.value = center.x;
    inputY.value = center.y;
    console.log(inputX.value);
    console.log(inputY.value);
    return `<circle id="circle" cx="${center.x}" cy="${center.y}" r="${diameter/2}" fill="#${color}"></circle>`;
}