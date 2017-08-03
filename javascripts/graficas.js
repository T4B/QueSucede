function grafica_tabla(titulo,subtitulo){

    $('#container').highcharts({
        data: {
            table: document.getElementById('datatable')
        },
        chart: {
            type: 'column'
        },
        title: {
            text: titulo
        },
        subtitle: {
                text: subtitulo
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Totales'
            }
        },
        tooltip: {
                headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y} </b></td></tr>',
                footerFormat: '</table>',
                shared: false,
                useHTML: true
            },
        /*tooltip: {
            formatter: function() {
                return '<b>'+ this.series.name +'</b><br/>'+
                    this.y +' '+ this.x.toLowerCase();
            }
        },*/
        dataLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y +'%';
                        }
                    },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        lang:{
            printChart: 'Imprimir Grafica',
            downloadJPEG: 'Descargar imagen JPEG',
            downloadPDF: 'Descargar documento PDF',
            downloadPNG: 'Descargar imagen PNG',
            downloadSVG: 'Descargar imagenes vectoriales SVG'
        }
    });
}

function grafico_pastel(id_div,titulo,subtitulo,emergente,valor_tipo,colores){
    $('#pastel'+id_div).highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: titulo
            },
            subtitle: {
                text: subtitulo
            },
            tooltip: {
                formatter: function() {
                            return '<b>'+ this.point.name + emergente +' </b>'+ this.point.y;
                        }
            },
            //colors:['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
            colors: colores,
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#fff',
                        connectorColor: '#fff',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b> '+ this.percentage.toFixed(2) +' %';
                        }
                    },
                    showInLegend: true
                }
            },
            lang:{
            printChart: 'Imprimir Grafica',
            downloadJPEG: 'Descargar imagen JPEG',
            downloadPDF: 'Descargar documento PDF',
            downloadPNG: 'Descargar imagen PNG',
            downloadSVG: 'Descargar imagenes vectoriales SVG'
            },
            series: [{
                type: 'pie',
                name: 'Promociones',
                data: valor_tipo
            }]
    });
}

function grafica_lineal_tabla(titulo,subtitulo){

    $('#lineal').highcharts({
        data: {
            table: document.getElementById('datatablelineal')
        },
        chart: {        	
            type: 'line',
            marginRight: 50,
            marginBottom: 100
        },
        title: {
            text: titulo,
            x: -20 //center
        },
        subtitle: {
            text: subtitulo,
            x: -20 //center
        },
        yAxis: {
        	min: 0,
            allowDecimals: false,
            title: {
                text: 'Totales '
            }
        },
        tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y} </b></td></tr>',
                footerFormat: '</table>',
                shared: false,
                useHTML: true
        },
        dataLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold'
                },
                formatter: function() {
                    return this.y +'%';
                }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        lang:{
            printChart: 'Imprimir Grafica',
            downloadJPEG: 'Descargar imagen JPEG',
            downloadPDF: 'Descargar documento PDF',
            downloadPNG: 'Descargar imagen PNG',
            downloadSVG: 'Descargar imagenes vectoriales SVG'
        }
    });
}


function grafica_lineal(titulo,subtitulo,categoria,app,web,rapp,rweb){
    $('#container').highcharts({
        chart: {
            type: 'line',
            marginRight: 50,
            marginBottom: 100
        },
        title: {
            text: titulo,
            x: -20 //center
        },
        xAxis: {
            categories: categoria
        },
        yAxis: {
            title: {
                text: titulo
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        legend: {
            symbolWidth: 80
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: [{
            name: "<b>"+rapp+"</b>",
            data: app
        }, {
            name: "<b>"+rweb+"</b>",
            data: web
        }]
    });


}