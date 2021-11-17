/**        ALL GRAPH OPTIONS         **/
var optionsLastYearMonthly = {
	series: [
		{
			name: 'In',
			data: []
		},
		{
			name: 'Out',
			data: []
		}
	],
	annotations: {
		position: 'back'
	},
	dataLabels: {
		enabled:false
	},
	chart: {
		type: 'bar',
		height: 300
	},
	fill: {
		opacity:1
	},
	plotOptions: {
	},
	colors: ['#435ebe','#55c6e8'],
	xaxis: {
		categories: ["Jan","Feb","Mar","Apr","May","Jun","Jul", "Aug","Sep","Oct","Nov","Dec"],
	},
}
let optionsLastMonthTransactions  = {
	series: [[],[]],
	labels: ['IN', 'Out'],
	colors: ['#435ebe','#55c6e8'],
	chart: {
		type: 'donut',
		width: '100%',
		height:'350px'
	},
	legend: {
		position: 'bottom'
	},
	plotOptions: {
		pie: {
			donut: {
				size: '60%',
				labels: {
					show: true,
					total: {
					  show: true,
					  label: 'Total',
					  color: '#373d3f',
					}
			}}
		}
	}
}

var optionsCategoryLastThirtyDayTransactions = {
	series: [{
		name: 'In',
		data: [310, 800, 600, 430, 540, 340, 605, 805,430, 540, 340, 605]
	},
	{
		name: 'Out',
		data: [310, 800, 600, 430, 340, 340, 605, 805,230, 140, 840, 305]
	}],
	chart: {
		height: 80,
		type: 'area',
		toolbar: {
			show:false,
		},
	},
	colors: ['#5350e9','#dc3545'],
	stroke: {
		width: 2,
	},
	grid: {
		show:false,
	},
	dataLabels: {
		enabled: false
	},
	xaxis: {
		type: 'datetime',
		categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z","2018-09-19T07:30:00.000Z","2018-09-19T08:30:00.000Z","2018-09-19T09:30:00.000Z","2018-09-19T10:30:00.000Z","2018-09-19T11:30:00.000Z"],
		axisBorder: {
			show:false
		},
		tooltip: {
			enabled: false
		},
		axisTicks: {
			show:false
		},
		labels: {
			show:false,
		}
	},
	show:false,
	yaxis: {
		labels: {
			show:false,
		},
	},
	tooltip: {
		x: {
			format: 'yyyy-MM-dd'
		},
	},
};




/** FUNCTIONS  **/
        // GENERATE DYNAMIC CHART FOR EACH CATEGORY DATA AND RETURN ARRAY OF CHART INSTANCES
        function initCategoryCharts(initOptions, data, parent, svg_url, chart_id_start = 'chart-thirty-days-transaction-') {
            let result = [];
            const date_values = getLastThirtyDays();
            data.forEach(category => {
                let transaction_in = {
                    ...date_values
                };
                let transaction_out = {
                    ...date_values
                };
                category.grant_transactions.forEach(transaction => {
                    transaction_in[transaction['date']] = parseInt(transaction['total_quantity'])
                });
                category.request_transactions.forEach(transaction => {
                    transaction_out[transaction['date']] = parseInt(transaction['total_quantity'])
                });

                const chart_id = 'chart-thirty-days-transaction-' + category.id;
                const chart_body = generateChartBody(chart_id, category.name, category.stock,
                    bootstrapTextColorRandom(), svg_url);
                parent.insertAdjacentHTML('beforeend', chart_body);
                let options = {
                    ...initOptions
                };
                options.series = [{
                        name: 'In',
                        data: Object.values(transaction_in)
                    },
                    {
                        name: 'Out',
                        data: Object.values(transaction_out)
                    }
                ];
                options.xaxis.categories = Object.keys(date_values);
                options.colors = [hexColorRandom(), hexColorRandom()];
                let chart = new ApexCharts(document.querySelector("#" + chart_id),
                    options);
                result.push(chart);
            });

            return result;
        }


        //chart body for each category last 30 days chart
        function generateChartBody(id, name, stock, fill, svg, name_length = 13) {
            name = name.slice(0, name_length) + '...';
            const graph_container = `<div class="row pb-2">
                            <div class="col-8">
                                <div class="d-flex align-items-center">
                                    <svg class="bi ${fill}" width="32" height="32" fill="blue" style="width:10px">
                                        <use
                                            xlink:href="${svg}" />
                                    </svg>
                                    <h6 class="mb-0 ms-3">${name}</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <h6 class="mb-0">${stock}</h6>
                            </div>
                            <div class="col-12">
                                <div id="${id}"></div>
                            </div>
                        </div>`;
            return graph_container;
        }

        //get an array of last 30 days date paired with zero initial values
        function getLastThirtyDays() {
            const date_now = new Date() // today, now
            var result = {};
            result[date_now.toISOString().slice(0, 10)] = 0;
            for (let i = 0; i < 29; i++) {
                date_now.setDate(date_now.getDate() - 1); // Decrease days
                result[date_now.toISOString().slice(0, 10)] = 0; // Set value to zero
            }
            return result;
        }

        // RETURN A RANDOM BOOTSTRAP TEXT COLOR
        function bootstrapTextColorRandom(array) {
            const bootstrapColors = ['text-gray-300', 'text-primary', 'text-secondary', 'text-dark', 'text-danger',
                'text-gray-600',
                'text-sucess', 'text-gray-900', 'text-warning', 'text-body'
            ];
            return bootstrapColors[Math.floor(Math.random() * bootstrapColors.length)];
        }

        // RETURN A RANDOM HEX COLOR
        function hexColorRandom() {
            const hexColors = ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6',
                '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
                '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
                '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
                '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
                '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
                '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
                '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
                '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
                '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'
            ];
            return hexColors[Math.floor(Math.random() * hexColors.length)];
        }

