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
			var chart_a; // Handle of a plot
			var trq_a;   // Handle of the timer to check if there are more files to plot
			var data_input_a=[]; // Points container
			var count_a=0;
			
			function requestData_1() { 
						
				$.ajax({
					type: "POST",
					url: 'file_plot_pressure.php',
					data: {},
					success: function (response) {
						//console.log(response);
						// Get points from the file
						$.get('plot_press_T.xml', function(xml) {
							var $xml = $(xml);
							var series = chart_a.series[0];
							
							var series_points=$xml.find('series data point').length;
							for (i = count_a; i < series_points; i++){
								data_input_a.push(eval($($xml.find('series data point')[i]).text()));
								/*console.log("index");
								console.log(i);
								console.log("count");
								console.log(count_a);
								console.log("data");
								console.log(eval($($xml.find('series data point')[i]).text()));*/
								count_a++;
							}
							
						});
						
						// Plot points
						var idt_p = setInterval(function(){
							if(data_input_a.length>0){
								clearInterval(trq_a); // Stop checking for files and start to plot
								var po2=data_input_a.shift(0,1); // Take first element from the vector
								//console.log(chart_a.series[0]);
								chart_a.series[0].addPoint(po2,true,chart_a.series[0].activePointCount>=19); // Plot element
							}
							if(data_input_a.length==0){
								trq_a=setTimeout(requestData_1, 2000); // Time to check if there are more files after everything is plot
								clearInterval(idt_p);  // Stop plotting and start to check for files 
							}
						},800); // Interval between points
					}
								  
				});
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
					},
					yAxis: {
						minPadding: 0.2,
						maxPadding: 0.2,
						title: {
							text: 'Value',
							margin: 20
						}
					},
					series: [{
						name: 'Pressure',
						data: []
					}]
				});		
			});
		</script>
	

<!-- ********************************** Speed - Elevation - Table   ********************************************************************-->		
		<script>
			var chart_f; // Handle of a plot
			var trq_f;   // Handle of the timer to check if there are more files to plot
			var data_speed=[]; // Points container
			var data_elevation=[]; // Points container
			var time_speed=[];
			var time_elevation=[];
			var counter_speed=0;
			var counter_elevation=0;
			var count_f=0;
			
			function requestData_6() { 
				
				$.get('PARSER_T.gpx', function(xml) {
					var $xml = $(xml);
					console.log("Step 1: Get xml file");
					var $coordinates=$($xml).find("trk trkseg trkpt");
					for(var i = counter_elevation; i < $coordinates.length;i++){
						var time_graph;
						$($coordinates[i]).find("time").each(function(i, time){
							time_graph=$(time).text();
							time_graph=time_graph.replace(/:/g,",");
							time_graph=time_graph.replace(/-/g,",");
							time_graph=time_graph.replace("T",",");
							time_graph=time_graph.replace("Z","");
							var str='Date.UTC(';
							time_graph=str.concat(time_graph.concat(')'));
							time_graph=eval(time_graph);
							
						});
					    if(i>0){
							var speed=distance_on_geoid($coordinates[i-1].getAttribute("lat"), $coordinates[i-1].getAttribute("lon"), 
								$coordinates[i].getAttribute("lat"), $coordinates[i].getAttribute("lon"));
							data_speed.push(speed);
							time_speed.push(time_graph);
						}
						
						$($coordinates[i]).find("ele").each(function(i, elevation){
							data_elevation.push(eval($(elevation).text()));
						});
						time_elevation.push(time_graph);
						
					}	

					// Get time trip and date
					var time1=$($($coordinates).first()).find("time").text();
					var time2=$($($coordinates).last()).find("time").text();
					
					var date=time1.substring(0,time1.indexOf("T"));
					document.getElementById('date_in').value=date;
					
					time1=time1.replace(/-/g,"/").replace("T"," ").replace("Z","");
					time2=time2.replace(/-/g,"/").replace("T"," ").replace("Z","");
					var time_init = new Date(time1);
					var time_end = new Date(time2);
					var time_diff = time_end-time_init;
					
					var msec = time_diff;
					var hh = Math.floor(msec / 1000 / 60 / 60);
					msec -= hh * 1000 * 60 * 60;
					var mm = Math.floor(msec / 1000 / 60);
					msec -= mm * 1000 * 60;
					var ss = Math.floor(msec / 1000);
					msec -= ss * 1000;
					
					document.getElementById('time_in').value=hh+":"+mm+":"+ss;
					console.log("Time");
					console.log(hh+":"+mm+":"+ss);
					
					var idt_p = setInterval(function(){
						if(data_speed.length>0){
							clearInterval(trq_f); // Stop checking for files and start to plot
							var speed_current=data_speed.shift(0,1); // Take first element from the vector
							var time_sc=time_speed.shift(0,1);
							//console.log(chart_a.series[0]);
							chart_f.series[0].addPoint([time_sc,speed_current],true,chart_f.series[0].activePointCount>=19); // Plot element
							document.getElementById('speed_in').value=Math.floor(speed_current*100)/100;
							counter_speed++;
						}
						if(data_elevation.length>0){
							clearInterval(trq_f); // Stop checking for files and start to plot
							var elevation_current=data_elevation.shift(0,1); // Take first element from the vector
							var time_ec=time_elevation.shift(0,1);
							//console.log(chart_a.series[0]);
							chart_g.series[0].addPoint([time_ec,elevation_current],true,chart_g.series[0].activePointCount>=19); // Plot element
							document.getElementById('elevation_in').value=Math.floor(elevation_current*100)/100;;
							counter_elevation++;
							
							
						}
						if(data_speed.length==0 && data_elevation.length==0 ){
							trq_f=setTimeout(requestData_6, 2000); // Time to check if there are more files after everything is plot
							clearInterval(idt_p);  // Stop plotting and start to check for files 
						}
					},800); // Interval between points
			});
								
			}
			function distance_on_geoid(lat1, lon1, lat2, lon2) {
				var R = 6371000; // meters
				var dLat = (lat2-lat1)*Math.PI / 180;  
				var dLon = (lon2-lon1)*Math.PI / 180;  
				var lat1 = lat1*Math.PI / 180;  
				var lat2 = lat2*Math.PI / 180;

				var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
						Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
				var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
				var d = R * c;
				
				return d;
			}
			
			$(document).ready(function() {
				chart_f = new Highcharts.Chart({
					chart: {
						renderTo: 'container_6',
						defaultSeriesType: 'spline',
						events: {
							load: requestData_6
						}
					},
					title: {
						text: 'ALTITUD 2 - GLOBODAQ',
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
					},
					yAxis: {
						minPadding: 0.2,
						maxPadding: 0.2,
						title: {
							text: 'Value',
							margin: 20
						}
					},
					series: [{
						name: 'Altitud',
						data: []
					}]
				});

				chart_g = new Highcharts.Chart({
					chart: {
						renderTo: 'container_7',
						defaultSeriesType: 'spline',
						events: {
							//load: requestData_6
						}
					},
					title: {
						text: 'SPEED 2 - GLOBODAQ',
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
					},
					yAxis: {
						minPadding: 0.2,
						maxPadding: 0.2,
						title: {
							text: 'Value',
							margin: 20
						}
					},
					series: [{
						name: 'Speed',
						data: []
					}]
				});
						
			});
		</script>
<!-- ********************************** MAPAAAAAA   ********************************************************************-->		

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
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
					
									
					
				setInterval(function(){
				// FILE INPUT
				
				$.ajax({
					type: "POST",
					url: 'file_manager_gnss2.php',
					data: {},
					success: function (response) {
								//alert(response);
						document.getElementById("file_complete").value=response;									
					}
								  
				});
					
				var file = document.getElementById("file_complete");
				//alert(file.value);
				//console.log(file);
				loadGPXFileIntoGoogleMap(map, file.value)},10000);
			});
		</script>
		
		
		<!-- **************** Image ************************ -->
		<script>

			$(document).ready(function() {
				
				console.log("Image init");
				
				var image_time = setInterval(function(){
					console.log("Image interval");
					$.ajax({
						type: "POST",
						url: 'last_image_upload.php',
						data: {},
						success: function (response) {
							console.log("Image file");
							console.log(response);
							document.getElementById("image_link").href=response;
							document.getElementById("image").src=response;
						}
								
					});
				},10000);
						
			});
		</script>


	</head>

	<body>
	
	


<!-- ***************************************************************************************************************************-->		
		<div id="titles" style="width:100%;vertical-align: middle;height:auto;margin:10px;">
			
			<img src="images/Globologo.png" alt="Globo DAQ logo" style="display:inline;width:30%;height: auto;margin-left: auto;margin-right: auto;"> </img>
			<div id="title" style="display:inline-block;width:30%; text-align:center;height:auto;margin-left: auto;margin-right: auto;">
				<h1 style="text-align:center;vertical-align:middle;display:inline;">User interface</h1>
			</div>
			
			<img src="images/Toradexlogo.jpg" alt="Toradex logo" style="display:inline;width:30%; height:auto;margin-left: auto;margin-right: auto;"> </img>
		</div>
	
		
		<!-- 3. Add the container -->
		<div style="float:left;width: 100%;height: auto;max-width: 1000px;">
			<div id="container_0" style="float:left;width: 100%;height: auto;max-width: 600px;min-width: 300px;">
				<div id="map" style="width:100%;height:500px;"></div>
			</div>
			
			<a id="image_link" href="images/image_test.jpg" target="_black">
				<img id="image" src="images/image_test.jpg" alt="Test image" style="float:left;width:100%;max-width:300px; height:auto;margin:5px;"> </img>
			</a> 
			
			
			<table style="width:auto;max-width: 400px;float:left;margin:5px;font-size:xx-large " align="center">
			   <tr>
				<td>Date</td>
				 <td><input type="text" id="date_in" value="" style="font-size:80%;width:70%;max-width:200px"></td> 
			   </tr>
			   <tr>
				<td>Time</td>
				 <td> <input type="text" id="time_in" value="02:30" style="font-size:80%;width:70%;max-width:200px"></td> 
			   </tr>
			   <tr>
				<td>Satellites</td>
				 <td> <input type="text" id="satellite_in" value="17" style="font-size:80%;width:70%;max-width:200px"></td> 
			   </tr>
			   <tr>
				<td>Elevation</td>
				 <td><input type="text" id="elevation_in" value="1200 m" style="font-size:80%;width:70%;max-width:200px"> </td> 
			   </tr>
			   <tr>
				<td>Speed</td>
				 <td> <input type="text" id="speed_in" value="40 km/h" style="font-size:80%;width:70%;max-width:200px"> </td> 
			   </tr>
			   <tr>
				<td>Hdop</td>
				 <td><input type="text" id="Hdop_in" value="0.3%" style="font-size:80%;width:70%;max-width:200px"> </td> 
			   </tr>
			</table> 
			
		</div>
		
		
		<div id="container_1" style="float:left;max-width: 600px;min-width:300px;width:30%;max-height: 600px;min-height:300px;height:50%;margin:10px;"></div>
		<div id="container_2" style="float:left;max-width: 600px;min-width:300px;width:30%;max-height: 600px;min-height:300px;height:50%;margin:10px;"></div>
		<div id="container_3" style="float:left;max-width: 600px;min-width:300px;width:30%;max-height: 600px;min-height:300px;height:50%;margin:10px;"></div>
		<div id="container_4" style="float:left;max-width: 600px;min-width:300px;width:30%;max-height: 600px;min-height:300px;height:50%;margin:10px;"></div>
		<div id="container_5" style="float:left;max-width: 600px;min-width:300px;width:30%;max-height: 600px;min-height:300px;height:50%;margin:10px;"></div>
		<input type = "hidden" id="file_complete" name="file_complete" value="<?php echo $file_name; ?>" > </input>
		
		<div id="container_6" style="float:left;max-width: 600px;min-width:300px;width:30%;max-height: 600px;min-height:300px;height:50%;margin:10px;"></div>
		<div id="container_7" style="float:left;max-width: 600px;min-width:300px;width:30%;max-height: 600px;min-height:300px;height:50%;margin:10px;"></div>
		
		

	</body>
</html>
