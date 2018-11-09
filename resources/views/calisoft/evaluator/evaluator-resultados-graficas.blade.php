@extends('layouts.dash') 

<script type="text/javascript" src="{{asset ('assets/Chart.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{asset ('assets/utils.js')}}"></script>

@section('content')
<div class="col-md-12">
    @component('components.portlet', ['icon' => 'fa fa-users', 'title' => 'Graficas Usuario', 'pdf' => route('pdf.resultados', compact('usuario'))])


    <div id="app">
            <div id="container" style="width: 100%;">
                    <canvas id="canvas"></canvas>
            </div>
    </div>
    @include('partials.modal-help-usuario') @endcomponent
</div>
@endsection @push('styles')
<link rel="stylesheet" href="/assets/global/plugins/bootstrap-toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css"> @endpush @push('functions')
<script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-validation/js/localization/messages_es.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>

<script src="/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>

<script>window.usuarioId = {{ $usuario->PK_id }};</script>
<script src="/js/resultados.js"></script>
<script>

	var datos;
	var MONTHS;
	var color;
	var barChartData;
	var label = [];
	var dataFuncionario = [];
	var dataIndicador = [];
	var nombre = ' {{ $usuario->name }}';
	var titulo = "INDICADORES vs FUNCIONARIO" + nombre.toUpperCase();

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			axios.get("/api/pruebas/" + {{ $usuario->PK_id }}).then(function (res) {
				//console.log(res.data);
				datos = res.data;
				console.log(datos);
				for (i in datos) {
					console.log(datos[i].nombreIndicador);
					label[i] = datos[i].nombreIndicador;
					dataFuncionario[i] = datos[i].respuestaUsuario;
					dataIndicador[i] = datos[i].metaIndicador;
				}
				console.log(label);
				MONTHS = ['', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
				color = Chart.helpers.color;
				barChartData = {
					labels: label,
					datasets: [{
						label: 'Funcionario',
						backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
						borderColor: window.chartColors.red,
						borderWidth: 1,
						data: dataFuncionario
					}, {
						label: 'Meta indicador',
						backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
						borderColor: window.chartColors.blue,
						borderWidth: 1,
						data: dataIndicador
					}]
		
				};
				// Define a plugin to provide data labels
		Chart.plugins.register({
			afterDatasetsDraw: function(chart) {
				var ctx = chart.ctx;

				chart.data.datasets.forEach(function(dataset, i) {
					var meta = chart.getDatasetMeta(i);
					if (!meta.hidden) {
						meta.data.forEach(function(element, index) {
							// Draw the text in black, with the specified font
							ctx.fillStyle = 'rgb(0, 0, 0)';

							var fontSize = 32;
							var fontStyle = 'normal';
							var fontFamily = 'Helvetica Neue';
							ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

							// Just naively convert to string for now
							var dataString = dataset.data[index].toString();

							// Make sure alignment settings are correct
							ctx.textAlign = 'center';
							ctx.textBaseline = 'middle';

							var padding = 5;
							var position = element.tooltipPosition();
							ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
						});
					}
				});
			}
		});

				window.myBar = new Chart(ctx, {
					type: 'bar',
					data: barChartData,
					options: {
						responsive: true,
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						},
						legend: {
							position: 'top',
						},
						title: {
							display: true,
							text: titulo
						}
					}
				});
			});
			

		};

		
	</script>

@endpush