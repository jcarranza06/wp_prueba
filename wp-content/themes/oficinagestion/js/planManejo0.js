console.log('tamo activo')
var data;

urlBaseFunctions = 'https://ogabogota.unal.edu.co/wp-content/themes/oficinagestion/includes/functions/';

function getMetas() {
    const valores = window.location.search;
    const urlParams = new URLSearchParams(valores);
    var facultad = urlParams.get('FACULTAD');
    //tituloPaginaPlanManejo = document.getElementById("tituloPaginaPlanManejo")
    //tituloPaginaPlanManejo.innerHTML = facultad
    tituloPaginaPlanManejo.innerHTML = 'Objetivos';
    callDB({ FACULTAD: facultad });
}

function callDB(facultad) {
    url = new URL(urlBaseFunctions+"get_objetivos_facultad.php")
    Object.keys(facultad).forEach(key => url.searchParams.append(key, facultad[key]));
    fetch(url)
        .then((response) => response.json())
        .then((data) => formatData(data));
}

var datas;
function formatData(data) {
    data = data;
    fdata = []
    objetivo = {
        id: 0
    }
    for (var i = 0; i < data.length; i++) {
        if (objetivo.id != data[i].ID_OBJETIVO) {
            objetivo = {
                id: data[i].ID_OBJETIVO,
                nombre: data[i].NOMBRE_OBJETIVO,
                metas: []
            }
            fdata.push(objetivo);
        }
        meta = {
            nombre: data[i].NOMBRE_META,
            descripcion: data[i].DESCRIPCION_META,
            avance: data[i].AVANCE,
            color: '#' + data[i].COLOR,
            ponderado: data[i].PONDERACION
        }
        objetivo.metas.push(meta)
    }

    setCharts(fdata);
}

function setCharts(data) {
    console.log(data);
    var chartColors = ['rgb(75, 192, 192)', 'rgb(236, 87, 47)', 'rgb(72, 151, 18)', 'rgb(141, 64, 176)', 'rgb(57, 65, 186)', 'rgb(57, 65, 186)', 'rgb(57, 65, 186)', 'rgb(57, 65, 186)', 'rgb(57, 65, 186)', 'rgb(57, 65, 186)', 'rgb(57, 65, 186)', 'rgb(57, 65, 186)', 'rgb(57, 65, 186)']
    var objetivesContainer = document.getElementById("objetivesContainer");
    dataResume = []

    var charts = [];
    var resumes = [];

    for (var i = 0; i < data.length; i++) {

        objetiveContainer = document.createElement("div");
	contentObjetiveContainer = document.createElement("div");
        objetiveContainer.innerHTML = "<h3 class='goalTitle'>" + data[i].nombre + "</h3> "
        objetiveContainer.classList += " objetiveContainer"
	contentObjetiveContainer.classList += " contentObjetiveContainer"

        goalsContainer = document.createElement("div");
        goalsContainer.classList += " goalsContainer"
        goalsContainer.classList += " rowObjetive"
        resumeContainer = document.createElement("div");
        resumeContainer.classList += " resumeContainer"
        resumeContainer.classList += " rowObjetive"
        resumeChart = document.createElement("canvas");
        resumeChart.id = "cresumeChart" + i;
        resumes[i] = { DomElement: resumeChart };

        dataResume[i] = {
            labels: [],
            data: []
        }
        var total = 0;
        colores = []
        for (var j = 0; j < data[i].metas.length; j++) {
            color = hexToRgb(data[i].metas[j].color);
            color  = ('rgb('+ color.r +',' + color.g+','+ color.b+')')
            colores.push(color)
            dataResume[i].labels.push(data[i].metas[j].nombre)
            dataResume[i].data.push({ avance: data[i].metas[j].avance, ponderado: data[i].metas[j].ponderado })
            total += data[i].metas[j].ponderado*1;

            goal = document.createElement("div");
            goal.classList += " goal"

            goalContainer = document.createElement("div");
            goalContainer.classList += " goalContainer"
            goalContainer.classList += " rowObjetive"
            chartContainer = document.createElement("div");
            chartContainer.classList += " chartContainer"
            chartContainer.classList += " rowObjetive"

            goalContainer.innerHTML = "<div>" + data[i].metas[j].nombre + "</div>"

            chart = document.createElement("canvas");
            chart.id = "chart" + i + "-" + j;

            chartContainer.appendChild(chart)
            goal.appendChild(goalContainer)
            goal.appendChild(chartContainer)

            goalsContainer.appendChild(goal)
            charts[i] = []
            charts[i][j] = chart;

            new Chart(charts[i][j], {
                type: 'doughnut',
                data: {
                    labels: ['avance', ''],
                    datasets: [{
                        data: [data[i].metas[j].avance, (100 - data[i].metas[j].avance)],
                        backgroundColor: [
                            color,
                            'rgb(221,221,221)'
                        ],
			borderWidth: 0,
                        hoverOffset: 4,
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    }
                }
            });
        }
        dataResume[i].total = total;
        colores.push('rgb(221,221,221)')
	const labelTooltip = (tooltipItems) =>{
            return tooltipItems.formattedValue + ' %';
        }
	const counter = {
            id: 'counter',
            beforeDraw(chart, args, options){
                const {ctx, chartArea:{ top, right, bottom, left, width, height}} = chart;
                txtSize = height*0.15;
                ctx.save();
                ctx.font = txtSize+"px "+ options.font;
                console.log(height)
		ctx.fillStyle = options.fontColor;
                //ctx.fillRect((width / 2) -5, top + (height/2) + -64, 10,64);
                ctx.textAlign = 'center';
                ctx.fillText(options.total+'%', width / 2, top + (height/2)+(txtSize * 0.354) );
            }
        };
        resumes[i].chart = new Chart(resumeChart, {
            type: 'polarArea',
            data: {
                labels: ['avance', ''],
                datasets: [{
                    data: [75, 100 - 75],
                    backgroundColor: colores,/*[
                        'rgb(255, 99, 132)',
                        'rgb(255,255,255)'
                    ],*/
                    hoverOffset: 4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip:{
                        displayColors: false,
                        callbacks: {
                            label: labelTooltip
                        }
                    },
                    counter: {
                        font: /*'sans-serif',*/ 'Ancizar sans',
			fontColor: '#333333',
                        total: 5
                    }
                },
                scales: {
                    r: {
                        suggestedMin: 0,
                        suggestedMax: 100,
                        stepSize: 20
                    }
                }
            }
        });

        resumeContainer.appendChild(resumeChart)
        contentObjetiveContainer.appendChild(goalsContainer)
        contentObjetiveContainer.appendChild(resumeContainer)
        objetiveContainer.appendChild(contentObjetiveContainer)
        objetivesContainer.appendChild(objetiveContainer)
    }

    for (var i = 0; i < dataResume.length; i++) {
        dataf = []
        restante = 100
        for (var j = 0; j < dataResume[i].data.length; j++) {
	    console.log("a "+ dataResume[i].data[j].avance+"* p "+ dataResume[i].data[j].ponderado +"/ t "+dataResume[i].total);
            n = redondear(dataResume[i].data[j].avance, 1);
            console.log(n);
            dataf.push(n)
            restante -= n
        }
        //dataf.push(restante)
        //dataResume[i].labels.push("Restante")
        dataResume[i].dataf = dataf;
	console.log(dataResume[i].dataf);
	resumes[i].chart.options.plugins.counter.total = redondear(100 - restante, 0);
        resumes[i].chart.data.labels = dataResume[i].labels;
        resumes[i].chart.data.datasets[0].data = dataResume[i].dataf;
        resumes[i].chart.update();
    }
}
function hexToRgb(hex) {
    /*para pasar un color en hex #01d451 a rgb rgb(255,221,225)
    */
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
      r: parseInt(result[1], 16),
      g: parseInt(result[2], 16),
      b: parseInt(result[3], 16)
    } : null;
  }

function redondear(n, d) {
    //n = valor a redondear
    //d = numero de decimales 
    d = Math.pow(10, d)
    return Math.round(n * d) / d
}

getMetas();
