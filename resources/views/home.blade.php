@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-2">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">Número de Periodistas</div>
                <div class="card-body">
                  <h5 class="card-title">{{ $num_periodistas }}</h5>
                </div>
              </div>
        </div>
        <div class="col-md-2">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">Número de Alarmas</div>
                <div class="card-body">
                  <h5 class="card-title">{{ $num_alertas }}</h5>
                </div>
              </div>
        </div>
    </div>
    <div class="row justify-content-center p-3">
        <div class="col-md-12">
            <div id="map" style="height: 300px;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div id="chart" style="width:100%; height:400px;"></div>
        </div>
        <div class="col-md-6">
            <div id="actores_chart" style="width:100%; height:400px;"></div>
        </div>
    </div>
</div>

<script>
    window.onload = () => {
        map = L.map('map').setView([4.624335, -74.063644], 5);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        $.get('/api/alerts', (data) => {
            for(i in data){
                geo = data[i].fields.Geoposicion;
                name = data[i].fields.Name;
                geo = geo.split(',');
                marker = L.marker([parseFloat(geo[0]), parseFloat(geo[1])]).addTo(map);
                marker.bindPopup("<b>" + name + "</b>");
            }
        })
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $.get('/api/types', (data) => {
            categories = []
            count = []
            for(i in data){
                categories.push(data[i].fields.Name)
                if(data[i].fields.Alertas != undefined){
                    count.push(data[i].fields.Alertas.length)
                }
            }

            const chart = Highcharts.chart('chart', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Tipo de amenazas'
                },
                xAxis: {
                    categories: categories
                },
                yAxis: {
                    title: {
                        text: 'Número de amenzas'
                    }
                },
                series: [{
                    name: 'Casos',
                    data: count
                }]
            });
        })
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $.get('/api/actors', (data) => {
            categories = []
            count = []
            for(i in data){
                categories.push(data[i].fields.Name)
                if(data[i].fields.Alertas != undefined){
                    serie_data = {
                        name: data[i].fields.Name,
                        y: data[i].fields.Alertas.length
                    }
                    count.push(serie_data)
                    //count.push(data[i].fields.Alertas.length)
                }
            }

            const chart = Highcharts.chart('actores_chart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Actores'
                },
                xAxis: {
                    categories: categories
                },
                yAxis: {
                    title: {
                        text: 'Número de amenzas'
                    }
                },
                series: [{
                    name: 'Casos',
                    data: count
                }]
            });
        })
    });
</script>
@endsection
