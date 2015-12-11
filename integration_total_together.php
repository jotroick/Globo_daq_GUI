<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>
		
		
		<!-- 1. Add these JavaScript inclusions in the head of your page -->
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.js"></script>
		<script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
		
		
		<!-- 2. Add the JavaScript to initialize the chart on document ready -->
		
<!-- ********************************** FIRST PLOT********************************************************************-->	
		<script>
		var chart_a; // global
	
		var pasadas_a =0;
		/**
		 * Request data from the server, add it to the graph and set a timeout to request again
		 */
		function requestData_1() {
			$.get('data_t.xml', function(xml) {
				
				// Split the lines
				var $xml = $(xml);
				
				// push categories
				//$xml.find('categories item').each(function(i, category) {
				//	options.xAxis.categories.push($(category).text());
				//});
				
				// push series
				var series = chart_a.series[0];
				//var shift = series.data.length > 20;
				var datainput = [];
				$xml.find('series').each(function(i, series_p) {
					//var seriesOptions = {
						//name: $(series_p).find('name').text(),
					//	data: []
					//};
					
					// push data points
					$(series_p).find('data point').each(function(i, point) {
						
						console.debug("tres");
						console.debug(parseInt($(point).text()));
						//seriesOptions.data.push( parseInt($(point).text()));
						datainput.push(eval($(point).text()));
						
						console.debug("cinco");
						console.debug(eval($(point).text()));
						
						console.debug("seis");
						console.debug(datainput);
						
						
						
				     // setTimeout(requestData, 1000);
					   console.debug("cuatro");
						console.debug(chart_a.series);
					});
				
				
				var counter = 0;
				var idt = setInterval(function(){
					var shift = counter > 20 || pasadas_a > 1;
					chart_a.series[0].addPoint(datainput[counter],true,shift);
					counter++;
					if (counter === 30){ clearInterval(idt);}
					},1000);
					
					//setTimeout("clearInterval("+idt+")",10000);
			
					
				});
				//console.debug(seriesOptions);
						//chart.series[0].addPoint([1,15],true,shift);
					//chart.series[0].addPoint([2,35],true,shift);
					
					// add it to the options
					console.debug("Dos");
					console.debug(chart_a.series[0]);
					pasadas_a++;
					console.debug("ocho");
					console.debug(pasadas_a);
					
				setTimeout(requestData_1, 30000);
				
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
					text: 'PRESSURE - GLOBODAQ'
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
				//var shift = series.data.length > 20;
				var datainput = [];
				$xml.find('series').each(function(i, series_p) {
					//var seriesOptions = {
						//name: $(series_p).find('name').text(),
					//	data: []
					//};
					
					// push data points
					$(series_p).find('data point').each(function(i, point) {
						
						console.debug("tres");
						console.debug(parseInt($(point).text()));
						//seriesOptions.data.push( parseInt($(point).text()));
						datainput.push(eval($(point).text()));
						
						console.debug("cinco");
						console.debug(eval($(point).text()));
						
						console.debug("seis");
						console.debug(datainput);
						
						
						
				     // setTimeout(requestData, 1000);
					   console.debug("cuatro");
						console.debug(chart_b.series);
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
				//console.debug(seriesOptions);
						//chart.series[0].addPoint([1,15],true,shift);
					//chart.series[0].addPoint([2,35],true,shift);
					
					// add it to the options
					console.debug("Dos");
					console.debug(chart_b.series[0]);
					pasadas_b++;
					console.debug("ocho");
					console.debug(pasadas_b);
					
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
						
						console.debug("tres");
						console.debug(parseInt($(point).text()));
						//seriesOptions.data.push( parseInt($(point).text()));
						datainput.push(eval($(point).text()));
						
						console.debug("cinco");
						console.debug(eval($(point).text()));
						
						console.debug("seis");
						console.debug(datainput);
						
						
						
				     // setTimeout(requestData, 1000);
					   console.debug("cuatro");
						console.debug(chart.series);
					});
				
				
				var counter = 0;
				var idt = setInterval(function(){
					var shift = counter > 20 || pasadas > 1;
					chart.series[0].addPoint(datainput[counter],true,shift);
					counter++;
					if (counter === 30){ clearInterval(idt);}
					},1000);
					
					//setTimeout("clearInterval("+idt+")",10000);
			
					
				});
				//console.debug(seriesOptions);
						//chart.series[0].addPoint([1,15],true,shift);
					//chart.series[0].addPoint([2,35],true,shift);
					
					// add it to the options
					console.debug("Dos");
					console.debug(chart.series[0]);
					pasadas++;
					console.debug("ocho");
					console.debug(pasadas);
					
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

// Set the colour of the track line segements.
GPXParser.prototype.setTrackColour = function(colour) {
    this.trackcolour = colour;
}

// Set the width of the track line segements
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
                var map = new google.maps.Map(document.getElementById("map"),
                    mapOptions);
				setInterval(function(){
				var file = document.getElementById("file_complete");
				//alert(file.value);
				console.log(file);
                loadGPXFileIntoGoogleMap(map, file.value)},5000);
            });

        //]]>
</script>

<?php
//echo "Hello World!";


$path = "/home/kopero/public_html/datagps/"; 
$file_name = "PARSER_T.gpx";
$totalfile = $path.$file_name;


$latest_ctime = 0;
$latest_filename = ''; 
$entry_before = '';   

$d = dir($path);
/// SELECT THE LATEST FILE
while (false !== ($entry = $d->read())) {
  $filepath = "{$path}/{$entry}";
  // could do also other checks than just checking whether the entry is a file
  if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
    $latest_ctime = filectime($filepath);
    $latest_filename = $entry;
  }
}

echo $latest_filename;
echo '<br>';

//if ( $entry_before  = $latest_filename)
//{
// break;
//}
//else 
//{
	//$entry_before  = $latest_filename;
 

	/// DELETE THE FIRST 5 LINES OF THE LATEST FILE (HEADER)
	
	$content = file($latest_filename);
	array_splice($content, 0, 5);
	file_put_contents($latest_filename, $content);
	
	/// DELETE THE LAST 3 LINE OF THE TOTAL FILE TO RECEIVE THE NEW DATA (FOOTER)

	$contents = file($totalfile);
	$line_1 = sizeof($contents) - 1 ;
	$line_2 = sizeof($contents) - 2 ;
	$line_3 = sizeof($contents) - 3 ;
	unset($contents[$line_1]);
	unset($contents[$line_2]);
	unset($contents[$line_3]);
	$fp = fopen($totalfile, 'w'); 
	fwrite($fp, implode('', $contents)); 
	fclose($fp); 
	
	/// APPEND THE LASTEST FILE MODIFIED INTO THE TOTAL FILE MODIFIED
	$copy_file = file_get_contents($latest_filename);
	//var_dump($copy_file);
	file_put_contents($totalfile, $copy_file, FILE_APPEND | LOCK_EX);
	?> 
	<input type = "hidden" id="file_complete" name="file_complete" value="<?php echo $file_name; ?>" > 
	<?php
	
	echo $totalfile;

//}

?> 
<!-- ***************************************************************************************************************************-->		
	</head>
	<body>
		
		<!-- 3. Add the container -->
		<div id="container_1" style="position:fixed; top: 30px; right:10px; width: 500px; height: 250px; margin: 0 auto"></div>
		<div id="container_2" style="position:fixed; top: 330px; right:10px; width: 500px; height: 250px; margin: 0 auto"></div>
		<div id="container_3" style="position:fixed; top: 630px; right:10px; width: 500px; height: 250px; margin: 0 auto"></div>
		<div id="map" style="position:fixed; top: 30px; left:10px; width: 800px; height: 800px;"></div>
		
	<!--	<div style="width: 800px; margin: 0 auto"> </div> -->
	</body>
</html>
