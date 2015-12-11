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
						/*data_input_a.pop();
						console.log("Data INSIDE after pop");
						console.log(data_input_a);*/
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
								//chart_a.series[0].addPoint(datainput[counter],true,shift);
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
		
<!-- ********************************** MAPAAAAAA   ********************************************************************-->		
		<script type="text/javascript"
            src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js">
        </script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript"> 

function GPXParser(xmlDoc, map) {
    this.xmlDoc = xmlDoc;
    this.map = map;
    this.trackcolour = "#ff00ff"; // red
    this.trackwidth = 1;
    this.mintrackpointdelta = 0.00001;
}

// Set the colour of the track line segments.
GPXParser.prototype.setTrackColour = function(colour) {
    this.trackcolour = colour;
}

// Set the width of the track line segments
GPXParser.prototype.setTrackWidth = function(width) {
    this.trackwidth = width;
}

// Set the minimum distance between trackpoints.
// Used to cull unneeded trackpoints from map.
GPXParser.prototype.setMinTrackPointDelta = function(delta) {
    this.mintrackpointdelta = delta;
}

GPXParser.prototype.translateName = function(name) {
    if(name == "wpt") {
        return "Waypoint";
    }
    else if(name == "trkpt") {
        return "Track Point";
    }
}


GPXParser.prototype.createMarker = function(point) {
    var lon = parseFloat(point.getAttribute("lon"));
    var lat = parseFloat(point.getAttribute("lat"));
    var html = "";

    var pointElements = point.getElementsByTagName("html");
    if(pointElements.length > 0) {
        for(i = 0; i < pointElements.item(0).childNodes.length; i++) {
            html += pointElements.item(0).childNodes[i].nodeValue;
        }
    }
    else {
        // Create the html if it does not exist in the point.
        html = "<b>" + this.translateName(point.nodeName) + "</b><br>";
        var attributes = point.attributes;
        var attrlen = attributes.length;
        for(i = 0; i < attrlen; i++) {
            html += attributes.item(i).name + " = " +
                    attributes.item(i).nodeValue + "<br>";
        }

        if(point.hasChildNodes) {
            var children = point.childNodes;
            var childrenlen = children.length;
            for(i = 0; i < childrenlen; i++) {
                // Ignore empty nodes
                if(children[i].nodeType != 1) continue;
                if(children[i].firstChild == null) continue;
                html += children[i].nodeName + " = " +
                        children[i].firstChild.nodeValue + "<br>";
            }
        }
    }

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat,lon),
        map: this.map
    });

    var infowindow = new google.maps.InfoWindow({
        content: html,
        size: new google.maps.Size(50,50)
    });

    google.maps.event.addListener(marker, "click", function() {
        infowindow.open(this.map, marker);
    });
}

GPXParser.prototype.addTrackSegmentToMap = function(trackSegment, colour,
        width) {
    var trackpoints = trackSegment.getElementsByTagName("trkpt");
    if(trackpoints.length == 0) {
        return;
    }

    var pointarray = [];

    // process first point
    var lastlon = parseFloat(trackpoints[0].getAttribute("lon"));
    var lastlat = parseFloat(trackpoints[0].getAttribute("lat"));
    var latlng = new google.maps.LatLng(lastlat,lastlon);
    pointarray.push(latlng);

    for(var i = 1; i < trackpoints.length; i++) {
        var lon = parseFloat(trackpoints[i].getAttribute("lon"));
        var lat = parseFloat(trackpoints[i].getAttribute("lat"));

        // Verify that this is far enough away from the last point to be used.
        var latdiff = lat - lastlat;
        var londiff = lon - lastlon;
        if(Math.sqrt(latdiff*latdiff + londiff*londiff)
                > 0 ){//this.mintrackpointdelta) {
            lastlon = lon;
            lastlat = lat;
            latlng = new google.maps.LatLng(lat,lon);
            pointarray.push(latlng);
        }

    }

    var polyline = new google.maps.Polyline({
        path: pointarray,
        strokeColor: colour,
        strokeWeight: width,
        map: this.map
    });
}

GPXParser.prototype.addTrackToMap = function(track, colour, width) {
    var segments = track.getElementsByTagName("trkseg");
    for(var i = 0; i < segments.length; i++) {
        var segmentlatlngbounds = this.addTrackSegmentToMap(segments[i], colour,
                width);
    }
}

GPXParser.prototype.centerAndZoom = function(trackSegment) {

    var pointlist = new Array("trkpt", "wpt");
    var minlat = 0;
    var maxlat = 0;
    var minlon = 0;
    var maxlon = 0;

    for(var pointtype = 0; pointtype < pointlist.length; pointtype++) {

        // Center the map and zoom on the given segment.
        var trackpoints = trackSegment.getElementsByTagName(
                pointlist[pointtype]);

        // If the min and max are uninitialized then initialize them.
        if((trackpoints.length > 0) && (minlat == maxlat) && (minlat == 0)) {
            minlat = parseFloat(trackpoints[0].getAttribute("lat"));
            maxlat = parseFloat(trackpoints[0].getAttribute("lat"));
            minlon = parseFloat(trackpoints[0].getAttribute("lon"));
            maxlon = parseFloat(trackpoints[0].getAttribute("lon"));
        }

        for(var i = 0; i < trackpoints.length; i++) {
            var lon = parseFloat(trackpoints[i].getAttribute("lon"));
            var lat = parseFloat(trackpoints[i].getAttribute("lat"));

            if(lon < minlon) minlon = lon;
            if(lon > maxlon) maxlon = lon;
            if(lat < minlat) minlat = lat;
            if(lat > maxlat) maxlat = lat;
        }
    }

    if((minlat == maxlat) && (minlat == 0)) {
        this.map.setCenter(new google.maps.LatLng(49.327667, -122.942333), 14);
        return;
    }

    // Center around the middle of the points
    var centerlon = (maxlon + minlon) / 2;
    var centerlat = (maxlat + minlat) / 2;

    var bounds = new google.maps.LatLngBounds(
            new google.maps.LatLng(minlat, minlon),
            new google.maps.LatLng(maxlat, maxlon));
    this.map.setCenter(new google.maps.LatLng(centerlat, centerlon));
    this.map.fitBounds(bounds);
}

GPXParser.prototype.centerAndZoomToLatLngBounds = function(latlngboundsarray) {
    var boundingbox = new google.maps.LatLngBounds();
    for(var i = 0; i < latlngboundsarray.length; i++) {
        if(!latlngboundsarray[i].isEmpty()) {
            boundingbox.extend(latlngboundsarray[i].getSouthWest());
            boundingbox.extend(latlngboundsarray[i].getNorthEast());
        }
    }

    var centerlat = (boundingbox.getNorthEast().lat() +
            boundingbox.getSouthWest().lat()) / 2;
    var centerlng = (boundingbox.getNorthEast().lng() +
            boundingbox.getSouthWest().lng()) / 2;
    this.map.setCenter(new google.maps.LatLng(centerlat, centerlng),
            this.map.getBoundsZoomLevel(boundingbox));
}

GPXParser.prototype.addTrackpointsToMap = function() {
    var tracks = this.xmlDoc.documentElement.getElementsByTagName("trk");
	
    for(var i = 0; i < tracks.length; i++) {
  
	   this.addTrackToMap(tracks[i], this.trackcolour, this.trackwidth);
	 //  setTimeout(function() {}, 100);
    }
}

GPXParser.prototype.addWaypointsToMap = function() {
    var waypoints = this.xmlDoc.documentElement.getElementsByTagName("wpt");
    for(var i = 0; i < waypoints.length; i++) {
        this.createMarker(waypoints[i]);
    }
}

</script>


        <script type="text/javascript">
            //<![CDATA[
			var map;
            function loadGPXFileIntoGoogleMap(map, filename) {
                $.ajax({url: filename,
                    dataType: "xml",
                    success: function(data) {
                      var parser = new GPXParser(data, map);
                      parser.setTrackColour("#ff0000");     // Set the track line colour
                      parser.setTrackWidth(5);          // Set the track line width
                      parser.setMinTrackPointDelta(0.001);      // Set the minimum distance between track points
                      parser.centerAndZoom(data);
                      parser.addTrackpointsToMap();         // Add the trackpoints
                      parser.addWaypointsToMap();           // Add the waypoints
                    //setTimeout(loadGPXFileIntoGoogleMap, 10000);
					}
					//setTimeout(loadGPXFileIntoGoogleMap, 10000);
                });
				//setTimeout(loadGPXFileIntoGoogleMap, 10000);	
			}
	
            $(document).ready(function() {
                var mapOptions = {
                  zoom: 8,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById("map"),
                    mapOptions);
					
				// Resize stuff...
				google.maps.event.addDomListener(window, "resize", function() {
				   var center = map.getCenter();
				   google.maps.event.trigger(map, "resize");
				   map.setCenter(center); 
				});
					
					
				setInterval(function(){
				// FILE INPUT
				
						$.ajax({
											type: "POST",
											url: 'file_manager_gnss.php',
											data: {},
											success: function (response) {
														console.log("holaaaa");
														//alert(response);
														document.getElementById("file_complete").value=response;									
													}
														  
										});
					
				var file = document.getElementById("file_complete");
				//alert(file.value);
				console.log(file);
                loadGPXFileIntoGoogleMap(map, file.value)},10000);
            });

        //]]>
</script>


</head>

<body>
	<input type = "hidden" id="file_complete" name="file_complete" value="<?php echo $file_name; ?>" > </input>
	


<!-- ***************************************************************************************************************************-->		
	
	
		
		<!-- 3. Add the container -->
		<div id="container_0" style="float:left;width: 70%; max-height: 800px;max-width: 800px;min-width: 400px; min-height: 400px;">
			<div id="map" style="overflow:visible;position:auto;width:800px;height:800px;position:none"></div>
		</div>
		
		
		<table style="width:100%;max-width: 400px;float:left;margin:5px; ">
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
		
		
		<img src="http://everythin4u.com/datagps/image_test.jpg" alt="Test image" style="float:left;width:304px; height:228px;margin:5px;"> </img>
		
		
		
		<div id="container_1" style="float:left;max-width: 600px;min-width:300px;width:30%;max-height: 600px;min-height:300px;height:50%;margin:10px;"></div>
		<div id="container_2" style="float:left; width: 500px;"></div>
		<div id="container_3" style="float:left;width: 500px;"></div>
		
		
		
		
	<!--	<div style="width: 800px; margin: 0 auto"> </div> -->
	</body>
</html>
