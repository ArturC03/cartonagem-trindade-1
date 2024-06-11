// const factory = document.getElementById("factory");
// const inputR = document.getElementById("cloud");
// const lastR = inputR.value;

// Chart.defaults.plugins.legend.display = false;
// var data = [
//         {
//             x: 50,
//             y: 50,
//             r: lastR,
//         },
//     ];

// const chart = new Chart(factory, {
//     type: "bubble",
//     data: {
//         datasets: [
//             {
//                 label: "Sensor",
//                 data: data,
//                 backgroundColor: "rgba(255, 99, 132, 0.6)",
//                 borderColor: "rgba(255, 99, 132, 1)",
//                 borderWidth: 1,
//             },
//         ],
//     },
//     options: {
//         maintainAspectRatio: true,
//         aspectRatio: imgX / imgY,
//         scales: {
//             x: {
//                 bounds: "ticks",
//                 ticks: {
//                     precision: 5,
//                 },
//                 min: 0,
//                 max: 100,
//                 display: false,
//                 grid: {
//                     display: false,
//                 },
//             },
//             y: {
//                 ticks: {
//                     precision: 5,
//                 },
//                 min: 0,
//                 max: 100,
//                 reverse: true,
//                 display: false,
//                 grid: {
//                     display: false,
//                 },
//             },
//         },
//         plugins: {
//             tooltip: {
//                 displayColors: false,
//                 callbacks: {
//                     title: function (context) {
//                         return context[0].dataset.label;
//                     },
//                     label: function (context) {
//                         var label = "";
//                         if (context.parsed.x !== null && context.parsed.y !== null) {
//                             label += "X: " + Math.round((context.parsed.x + Number.EPSILON) * 100) / 100 + ", Y: " + Math.round((context.parsed.y + Number.EPSILON) * 100) / 100;
//                         }
//                         return label;
//                     },
//                 },
//             },
//         },
//     },
// });

// var flag = false;

// factory.addEventListener("click", function (event) {
//     var rect = this.getBoundingClientRect();
//     var x = event.clientX - rect.left;
//     var y = event.clientY - rect.top;

//     // Convert the click coordinates to chart data coordinates
//     var xValue = chart.scales.x.getValueForPixel(x);
//     var yValue = chart.scales.y.getValueForPixel(y);

//     chart.data.datasets.forEach((dataset) => {
//         dataset.data.pop();
//     });

//     // Add a new bubble to the chart data
//     chart.data.datasets.forEach((dataset) => {
//         dataset.data.push({
//             x: xValue,
//             y: yValue,
//             r: inputR.value,
//         });
//     });

//     inputX.value = xValue;
//     inputY.value = yValue;
//     console.log(xValue, yValue);

//     // Update the chart
//     chart.update("none");

//     if (!flag) {
//         flag = true;

//         var rect = this.getBoundingClientRect();
//         var x = event.clientX - rect.left;
//         var y = event.clientY - rect.top;

//         // Convert the click coordinates to chart data coordinates
//         var xValue = chart.scales.x.getValueForPixel(x);
//         var yValue = chart.scales.y.getValueForPixel(y);

//         chart.data.datasets.forEach((dataset) => {
//             dataset.data.pop();
//         });

//         // Add a new bubble to the chart data
//         chart.data.datasets.forEach((dataset) => {
//             dataset.data.push({
//                 x: xValue,
//                 y: yValue,
//                 r: inputR.value,
//             });
//         });

//         inputX.value = xValue;
//         inputY.value = yValue;
//         console.log(xValue, yValue);

//         // Update the chart
//         chart.update("none");
//     }
// });

$(document).ready(function() {
    $("#bgImageInput, #emailImageInput").change(function() {
        const input = this;
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const previewId = input.id.replace("Input", "");
                $("#" + previewId).attr("src", e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    });
});