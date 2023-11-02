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
        btbarColors = btbarColors.concat("#" + Math.floor(Math.random() * 16777215).toString(16));
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
    var anz = phpData.anz;
    var anzs = [
        [
            {
                "weekNumber": 1,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 2,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 3,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 4,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 5,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 6,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 7,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 8,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 9,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 10,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 11,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 12,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 13,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 14,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 15,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 16,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 17,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 18,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 19,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 20,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 21,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 22,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 23,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 24,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 25,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 26,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 27,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 28,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 29,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 30,
                "NumberOfReservations": 0
            },
            {
                "0": "31",
                "1": "2",
                "weekNumber": "31",
                "NumberOfReservations": "2"
            },
            {
                "0": "32",
                "1": "45",
                "weekNumber": "32",
                "NumberOfReservations": "45"
            },
            {
                "0": "33",
                "1": "63",
                "weekNumber": "33",
                "NumberOfReservations": "63"
            },
            {
                "0": "34",
                "1": "58",
                "weekNumber": "34",
                "NumberOfReservations": "58"
            },
            {
                "0": "35",
                "1": "29",
                "weekNumber": "35",
                "NumberOfReservations": "29"
            },
            {
                "0": "36",
                "1": "12",
                "weekNumber": "36",
                "NumberOfReservations": "12"
            },
            {
                "0": "37",
                "1": "15",
                "weekNumber": "37",
                "NumberOfReservations": "15"
            },
            {
                "0": "38",
                "1": "7",
                "weekNumber": "38",
                "NumberOfReservations": "7"
            },
            {
                "0": "39",
                "1": "8",
                "weekNumber": "39",
                "NumberOfReservations": "8"
            },
            {
                "0": "40",
                "1": "2",
                "weekNumber": "40",
                "NumberOfReservations": "2"
            },
            {
                "0": "41",
                "1": "2",
                "weekNumber": "41",
                "NumberOfReservations": "2"
            },
            {
                "weekNumber": 42,
                "NumberOfReservations": 0
            },
            {
                "0": "43",
                "1": "3",
                "weekNumber": "43",
                "NumberOfReservations": "3"
            },
            {
                "weekNumber": 44,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 45,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 46,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 47,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 48,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 49,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 50,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 51,
                "NumberOfReservations": 0
            },
            {
                "weekNumber": 52,
                "NumberOfReservations": 0
            }
        ]
    ];
    var anzxValues = [];
    var anzyValues = [];

    console.log(anz);

    for (var i = 0; i < anz.length; i++) {
        anzxValues.push(anz[i].weekNumber);
        anzxValues[i] = parseInt(anzxValues[i]);
        anzyValues.push(anz[i].NumberOfReservations);
        anzyValues[i] = parseInt(anzyValues[i]);
    }

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
            legend: { display: false },
            scales: {
                xAxes: [{
                    ticks: {
                        // min: Math.min(...anzxValues), // Set the minimum value to the lowest data point
                        // max: Math.max(...anzxValues)  // Set the maximum value to the highest data point
                    }
                }],
                yAxes: [{
                    ticks: {
                        // min: Math.min(...anzyValues), // Set the minimum value to the lowest data point
                        // max: Math.max(...anzyValues)  // Set the maximum value to the highest data point
                    }
                }]
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