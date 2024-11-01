var getTimeElement = document.getElementById("myChart");
var title = JSON.parse(getTimeElement.getAttribute("data-title")).join(' ');
var type = getTimeElement.getAttribute("data-type");
var line_color = getTimeElement.getAttribute("data-line-color");
var color = JSON.parse(getTimeElement.getAttribute("data-color"));
var xValues = JSON.parse(getTimeElement.getAttribute("data-key"));
var yValues = JSON.parse(getTimeElement.getAttribute("data-value"));

if (type == 'line') {
    var mb_datasets = [{ borderColor: line_color, data: yValues, fill: false }];
    var mb_legend = false;
} else if (type == 'bar') {
    var mb_datasets = [{ backgroundColor: color, data: yValues, fill: false }];
    var mb_legend = false;
} else {
    var mb_datasets = [{ backgroundColor: color, data: yValues, fill: false }];
    var mb_legend = true;
}

new Chart("myChart", {
    type: type,
    data: {
        labels: xValues,
        datasets: mb_datasets,
    },
    options: {
        legend: { display: mb_legend },
        title: {
            display: true,
            text: title,
        }
    }
});
