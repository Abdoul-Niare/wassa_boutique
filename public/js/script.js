const menuIcon = document.querySelector('.menu-icon');
const sidebar = document.querySelector('#sidebar');
const header = document.querySelector('.header');

menuIcon.addEventListener('click', ToggleSidebar);

function ToggleSidebar() {
    if (sidebar.classList.contains('sidebar-responsive')) {
        sidebar.classList.remove('sidebar-responsive');
        menuIcon.querySelector('span').innerText =
            'KeyBoard_double_arrow_right';
        header.classList.remove('header-responsive');
    } else {
        sidebar.classList.add('sidebar-responsive');
        menuIcon.querySelector('span').innerText = 'menu';
        header.classList.add('header-responsive');
    }
}
let options = {
    series: [{
        data: [410, 430, 448, 470, 540]
    }],
    chart: {
        type: 'bar',
        height: 350,
        toolbar: {
            show: false,
        }
    },
    colors: ['#eba91d', '#bc1e51', '#42c3a7', '#434738', '#0b0c0e'],
    plotOptions: {
        bar: {
            horizontal: false,
            distributed: true,
            columnWidth: '40%'
        }
    },

    dataLabels: {
        enabled: false,
    },

    legend: {
        show: false,
    },

    xaxis: {
        categories: ['Computer', 'Android', 'ios', 'Ecouteurs', 'Camera'],
    },
    yaxis: {
        title: {
            text: 'Quantité'
        }
    }
};
let chartBar = new ApexCharts(document.querySelector("#chart-bar"), options);
chartBar.render();

// VENTES et REJETS.

let mixedOptions = {
    series: [{
        name: 'Ventes',
        type: 'column',
        data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
    }, {
        name: 'Prévisions',
        type: 'area',
        data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
    }, {
        name: 'Rejets',
        type: 'line',
        data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
    }],
    chart: {
        height: 350,
        stacked: false,
        toolbar: {
            show: false,
        }
    },
    colors: ['#0b0c0e', '#eba91d', '#bc1e51'],

    stroke: {
        width: [0, 2, 3],
        curve: 'smooth'
    },
    plotOptions: {
        bar: {
            columnWidth: '50%'
        }
    },

    fill: {
        opacity: [0.85, 0.25, 1],
        gradient: {
            inverseColors: false,
            shade: 'light',
            type: "vertical",
            opacityFrom: 0.85,
            opacityTo: 0.55,
            stops: [0, 100, 100, 100]
        }
    },
    labels: ['Jan', 'Fev', 'Mars', 'Avr', 'Mai', 'Juin', 'Juil',
        'Aout', 'Sept', 'Oct', 'Nov'
    ],
    markers: {
        size: 0
    },

    yaxis: {
        title: {
            text: 'Quantité',
        },
        min: 0
    },
    tooltip: {
        shared: true,
        intersect: false,
        // y: {
        //   formatter: function (y) {
        //     if (typeof y !== "undefined") {
        //       return y.toFixed(0) + " points";
        //     }
        //     return y;

        //   }
        // }
    }
};

let chartMixed = new ApexCharts(document.querySelector("#chart-area"), mixedOptions);
chartMixed.render();



