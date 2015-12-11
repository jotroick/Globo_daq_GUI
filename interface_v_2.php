<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> </meta>
		<title>Globo-Daq interface</title>
		
		
		<!-- 1. Add these JavaScript inclusions in the head of your page -->
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.js"></script>
		<script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
		
		
		<!-- 2. Add the JavaScript to initialize the chart on document ready -->
		
<!-- ********************************** FIRST PLOT********************************************************************-->	
		<script>
		var chart_a; // global
		var pressure_flag;
		
		var x=0;
	
		var pasadas_a =0;
		var points_a=0; // *****
		var data_input_a=[];
		/**
		 * Request data from the server, add it to the graph and set a timeout to request again
		 */
		function requestData_1() { 
		console.log("iniciando");
		//pressure_flag = 0;
		
		$.ajax({
			type: "POST",
			url: 'file_plot_1.php',
			data: {},
			success: function (response) {
			
				console.log("Step 1");
				//console.log("Response");
				//console.log(response);
				$.get('plot_press_T.xml', function(xml) {
					var $xml = $(xml);
					var series = chart_a.series[0];
					$xml.find('series').each(function(i, series_p) {
						$(series_p).find('data point').each(function(i, point) {
							//data_input_a.push(eval($(point).text()));	
							var po=eval($(point).text());
							data_input_a.unshift(po);
							chart_a.series[0].addPoint(po,true,true);
							console.log("Data to insert");
							console.log(po);
							console.log("Data");
							console.log(data_input_a);
						});	
					});
				});
				console.log("Data");
				console.log(data_input_a);
				console.log("Data length");
				console.log(data_input_a.length);
				
				var idt_p = setInterval(function(){
					//var shift = counter > 20 || pasadas_a > 1;
					var shift_f = true;
					/*console.log("Data length INSIDE");
					console.log(data_input_a.length);
					console.log("Data INSIDE");
					console.log(data_input_a);*/
					if(data_input_a.length>0){
						//chart_a.series[0].addPoint(data_input_a[0],true,shift_f); [x, y]
						//x++;
						//chart_a.series[0].addPoint([x, 10],true,shift_f);
						data_input_a.pop();
						console.log("Data INSIDE after pop");
						console.log(data_input_a);
					}
					if(data_input_a.length==0){
						clearInterval(idt_p);
					}
					console.log("End Inside loop");
				},1000);
				
			}
						  
		});
		
		
		
										
	//console.log("segundo check");
	//console.log(pressure_flag);
	
	
			//if (pressure_flag !=0)
			//{
			//console.log("Checking 1");
			//$.get('plot_press_T.xml', function(xml) {
			$.get('data_t.xml', function(xml) {
				
				// Split the lines
				var $xml = $(xml);
				//console.log($xml);
				var series = chart_a.series[0];
				//console.log("Checking 2");
				var datainput = [];
				$xml.find('series').each(function(i, series_p) {
					
					$(series_p).find('data point').each(function(i, point) {
						
																				datainput.push(eval($(point).text()));
																				//points_a++;
																				//console.log(points_a);
																				
																			});
				
				
					var counter = 0;
					//console.log("Number of points OUT");
					//console.log(datainput.length);
					
						var idt = setInterval(function(){
							var shift = counter > 20 || pasadas_a > 1 || true;
							//if(points_a!=0){
							/*console.log("Vector IN");
							console.log(datainput.length);
							console.log("Comparison");
							console.log(datainput.length>0);*/
							if(datainput.length>0){
								//console.log(datainput);
							}
							//if(datainput.length!=0){
								chart_a.series[0].addPoint(datainput[counter],true,shift);
							//}
							counter++;
							if (counter === datainput.length){
								points_a=datainput.length; // *****	
								clearInterval(idt);
							}
						},1000);
					
					//console.log("OUT");
					
				});
			
					pasadas_a++;
					setTimeout(requestData_1, 20000);
				
			} ) ;
			/*} else {
			setTimeout(requestData_1, 10000);
			console.log("estamos in else");
			}*/
			
		}
			
		$(document).ready(function() {
			chart_a = new Highcharts.Chart({
				chart: {
					renderTo: 'container_1',
					defaultSeriesType: 'spline',
					events: {
						load: requestData_1
					}
				},
				title: {
					text: 'PRESSURE - GLOBODAQ',
					margin:7,
					style:{"fontSize":"12px"}
				},           
				tooltip: {
					formatter: function () {
						return '<b>' + this.series.name + '</b><br/>' +
							Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
							Highcharts.numberFormat(this.y, 2);
					}
				},
				xAxis: {
					type: 'datetime',
					tickPixelInterval: 150
					
					//maxZoom: 20 * 1000
				},
				yAxis: {
					minPadding: 0.2,
					maxPadding: 0.2,
					title: {
						text: 'Value',
						margin: 80
					}
				},
				series: [{
					name: 'Random data',
					data: []
				}]
			});		
		});
		</script>
	
<!-- ********************************** SECOND PLOT********************************************************************-->	

<script>
		var chart_b; // global
		
		var pasadas_b =0;
		/**
		 * Request data from the server, add it to the graph and set a timeout to request again
		 */
		 
		function requestData_2() {
			$.get('data_t2.xml', function(xml) {
				
				// Split the lines
				var $xml = $(xml);
				
				// push categories
				//$xml.find('categories item').each(function(i, category) {
				//	options.xAxis.categories.push($(category).text());
				//});
				
				// push series
				var series = chart_b.series[0];
				
				var datainput = [];
				$xml.find('series').each(function(i, series_p) {
					//var seriesOptions = {
						//name: $(series_p).find('name').text(),
					//	data: []
					//};
					
					// push data points
						$(series_p).find('data point').each(function(i, point) {
							
																				datainput.push(eval($(point).text()));
							
																				});
				
				
						var counter = 0;
						var idt = setInterval(function(){
							var shift = counter > 20 || pasadas_b > 1;
							chart_b.series[0].addPoint(datainput[counter],true,shift);
							counter++;
							if (counter === 30){ clearInterval(idt);}
							},1000);
							
							//setTimeout("clearInterval("+idt+")",10000);
			
					
				});
			
					pasadas_b++;
					
				setTimeout(requestData_2, 30000);
				
			});
		}
			
		$(document).ready(function() {
			chart_b = new Highcharts.Chart({
				chart: {
					renderTo: 'container_2',
					defaultSeriesType: 'spline',
					events: {
						load: requestData_2
					}
				},
				title: {
					text: 'TEMPERATURE - GLOBODAQ'
				},
				xAxis: {
					text: 'datetime',
					//tickPixelInterval: 150,
					//maxZoom: 20 * 1000
				},
				yAxis: {
					minPadding: 0.2,
					maxPadding: 0.2,
					title: {
						text: 'Value',
						margin: 80
					}
				},
				series: [{
					name: 'Random data',
					data: []
				}]
			});		
		});
		</script>
	
<!-- ********************************** THIRD PLOT********************************************************************-->	
<script>
		var chart; // global
		var init=1;
		var pasadas =0;
		/**
		 * Request data from the server, add it to the graph and set a timeout to request again
		 */
		 
		function requestData() {
			$.get('data_t3.xml', function(xml) {
				
				// Split the lines
				var $xml = $(xml);
				
				// push categories
				//$xml.find('categories item').each(function(i, category) {
				//	options.xAxis.categories.push($(category).text());
				//});
				
				// push series
				var series = chart.series[0];
				//var shift = series.data.length > 20;
				var datainput = [];
				$xml.find('series').each(function(i, series_p) {
												//var seriesOptions = {
													//name: $(series_p).find('name').text(),
												//	data: []
												//};
												
												// push data points
								$(series_p).find('data point').each(function(i, point) {
									
												datainput.push(eval($(point).text()));

											});
							
							
							var counter = 0;
							var idt = setInterval(function(){
								var shift = counter > 20 || pasadas > 1;
								chart.series[0].addPoint(datainput[counter],true,shift);
								counter++;
								if (counter === 30){ clearInterval(idt);}
								},1000);
	
				
					});
			
					pasadas++;
					
				setTimeout(requestData, 30000);
				
			});
		}
			
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container_3',
					defaultSeriesType: 'spline',
					events: {
						load: requestData
					}
				},
				title: {
					text: 'HUMIDITY- GLOBODAQ'
				},
				xAxis: {
					text: 'datetime',
					//tickPixelInterval: 150,
					//maxZoom: 20 * 1000
				},
				yAxis: {
					minPadding: 0.2,
					maxPadding: 0.2,
					title: {
						text: 'Value',
						margin: 80
					}
				},
				series: [{
					name: 'Random data',
					data: []
				}]
			});		
		});
		</script>
		


<!-- ***************************************************************************************************************************-->		
	
	</head>
	<body>
		
		
		
		<iframe src="http://everythin4u.com/datagps/map_view.php" style="float:left; width: 70%; max-height: 1200px;max-width: 864px;min-width: 400px; min-height: 400px;"></iframe> 
		
		<div style="width:100%;max-width: 400px;float:left;">
			<table >
			   <tr>
				<td>Jill</td>
				 <td>Smith</td> 
				<td>50</td>
			   </tr>
			  <tr>
				<td>Eve</td>
				 <td>Jackson</td> 
				<td>94</td>
			   </tr>
			</table> 
		</div>
		
		<div style="float:left;width:500px;">
			<img src="http://everythin4u.com/datagps/image_test.jpg" alt="Test image" style="width:100%; height:100%"> </img>
		</div>
		
		
		
		<div id="container_1" style="float:left;width: 500px;"></div>
		<div id="container_2" style="float:left; width: 500px;"></div>
		<div id="container_3" style="float:left;width: 500px;"></div>
		
		
		
		
	<!--	<div style="width: 800px; margin: 0 auto"> </div> -->
	</body>
</html>
