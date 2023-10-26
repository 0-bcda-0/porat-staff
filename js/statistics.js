window.onload = function () {
    console.log(phpData);


// ----------------- Najpopularniji brodovi -----------------
// from phpData extract bt array, then go through it and extract boatName and NumberOfReservations in two separate arrays and then in btbarColors array put random colors for each boat
var bt = phpData.bt;
var btxValues = [];
var btyValues = [];
var btbarColors = [];

for (var i = 0; i < bt.length; i++) {
    btxValues.push(bt[i].boatName);
    btyValues.push(bt[i].NumberOfReservations);
    btyValues[i] = parseInt(btyValues[i]);
    btbarColors = btbarColors.concat("#" + Math.floor(Math.random()*16777215).toString(16));
}

new Chart("bt-chart", {
    type: "bar",
    data: {
        labels: btxValues,
        datasets: [{
            backgroundColor: btbarColors,
            data: btyValues
        }]
    }
});

// ----------------- Vodeća platforma -----------------
// from phpData extract vp array, then go through it and extract NumberOfReservation and platformName in two separate arrays
var vp = phpData.vp;
var vpxValues = [];
var vpyValues = [];
for (var i = 0; i < vp.length; i++) {
    vpxValues.push(vp[i].platformName);
    vpyValues.push(vp[i].NumberOfReservations);
}
// var npxValues = ["Italy", "France", "Spain", "USA", "Argentina"];
// var npyValues = [55, 49, 44, 24, 15];
var vpbarColors = [
"#b91d47",
"#00aba9",
"#2b5797",
"#e8c3b9",
"#1e7145"
];

new Chart("vp-chart", {
    type: "doughnut",
    data: {
    labels: vpxValues,
    datasets: [{
        backgroundColor: vpbarColors,
        data: vpyValues
    }]
    }
});

// ----------------- Analiza najbolje sezone -----------------
// const anzxValues = [50,60,70,80,90,100,110,120,130,140,150];
// const anzyValues = [7,8,8,9,9,9,10,11,14,14,15];

// from phpData extract anz array, then go through it and extract week and NumberOfReservations in two separate arrays
var anz = phpData.anz;
var anzxValues = [];
var anzyValues = [];

for (var i = 0; i < anz.length; i++) {
    anzxValues.push(anz[i].weekNumber);
    anzxValues[i] = parseInt(anzxValues[i]);
    anzyValues.push(anz[i].NumberOfReservations);
    anzyValues[i] = parseInt(anzyValues[i]);
}

// console.log(anzxValues);
// console.log(anzyValues);

// anzxValues = [50,60,70,80,90,100,110,120,130,140,150];
// anzyValues = [7,8,8,9,9,9,10,11,14,14,15];

// console.log(anzxValues);
// console.log(anzyValues);

new Chart("anz-chart", {
    type: "line",
    data: {
    labels: anzxValues,
    datasets: [{
        fill: false,
        lineTension: 0,
        backgroundColor: "rgba(0,0,255,1.0)",
        borderColor: "rgba(0,0,255,0.1)",
        data: anzyValues
    }]
    },
    options: {
    legend: {display: false},
    scales: {
        yAxes: [{ticks: {min: 6, max:16}}],
    }
    }
});

// ----------------- Rekordni najmodavac -----------------
// from phpData extract rn array, then go through it and extract employeeUsername and NumberOfReservations in two separate arrays
var rn = phpData.rn;
var rnEmployeeUsername = [];
var rnNumberOfReservations = [];
for (var i = 0; i < rn.length; i++) {
    rnEmployeeUsername.push(rn[i].employeeUsername);
    rnNumberOfReservations.push(rn[i].NumberOfReservations);
}
// var ndxValues = ["Italy", "France", "Spain", "USA", "Argentina"];
// var ndyValues = [55, 49, 44, 24, 15];
var ndxValues = rnEmployeeUsername;
var ndyValues = rnNumberOfReservations;
var ndbarColors = [
    "#b91d47",
    "#00aba9",
    "#2b5797",
    "#e8c3b9",
    "#1e7145"
];

new Chart("nd-chart", {
    type: "pie",
    data: {
    labels: ndxValues,
    datasets: [{
        backgroundColor: ndbarColors,
        data: ndyValues
    }]
    }
});

// ----------------- Top 5 država klijenata -----------------
// var drzxValues = ["Italy", "France", "Spain", "USA", "Argentina"];
// var drzyValues = [55, 49, 44, 24, 15];
// var drzbarColors = [
//     "#b91d47",
//     "#00aba9",
//     "#2b5797",
//     "#e8c3b9",
//     "#1e7145"
// ];

// new Chart("drzave-chart", {
//     type: "doughnut",
//     data: {
//     labels: drzxValues,
//     datasets: [{
//         backgroundColor: drzbarColors,
//         data: drzyValues
//     }]
//     }
// });


};