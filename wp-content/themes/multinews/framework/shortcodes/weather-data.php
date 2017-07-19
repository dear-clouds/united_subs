<?php
//Weather Maps 
function mom_weather_map ($atts, $content = null) {
   extract(shortcode_atts(array(
      "width" => '536',
      "height" => '370',
      "city" => '',
      "zoom" => 1,
      "layer" => 'rain' /*rain, clouds, precipitation, pressure, wind, temp, snow*/
   ), $atts));
if (isset($_POST['location']) && $_POST['location'] != '') {
    $city = $_POST['location'];
}

    $api_key = mom_option('weather_api_key');
if ($api_key == '') {
    //$api_key = '8cf2ffe6901005e706ec4e9c593588e2';
    echo __('Please Go to Theme options -> API\'s Authentication and add the weather API key');
    return;
}

      ob_start();
        $rndn = rand(1,100);
            wp_enqueue_script('open_weather_map', '//openlayers.org/api/OpenLayers.js', '', '1.0', false);
            if ($city != '') {
if (isset($_COOKIE['lon']) && $_COOKIE['lon'] != '') {
    $lon = isset($_COOKIE['lon']) ? $_COOKIE['lon'] : '';
    $lat = isset($_COOKIE['lat']) ? $_COOKIE['lat'] : '';
} else {
    $lon = isset($_POST['lon']) ? $_POST['lon'] : '';
    $lat = isset($_POST['lat']) ? $_POST['lat'] : '';
    if ($lat != '' && $lon != '') {
        mom_setcookie('lat',$lat);
        mom_setcookie('lon',$lon);
    }
}
if ($lat != '' && $lon != '') {
                $city_url = wp_remote_get('http://api.openweathermap.org/data/2.5/weather?lat='.$lat.'&lon='.$lon.'&appid='.$api_key);
            } else {
                $city_url = wp_remote_get('http://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid='.$api_key);
            }
	if (!is_wp_error($city_url)) {
                $city_json = json_decode( $city_url['body'], true );
                $lon = $city_json['coord']['lon'];
                $lat = $city_json['coord']['lat'];
                if ($zoom == 1) {
                    $zoom = 5;
                }
	} else {
	    return false;
	 }		
            } else {
                $lat = 0;
                $lon = 0;
            }
    ?>
            <script>
jQuery(document).ready(function ($) {

function init()
{
	var args = OpenLayers.Util.getParameters();
	var layer_name = '<?php echo $layer; ?>';
	var lat = <?php echo $lat; ?>;
	var lon = <?php echo $lon; ?>;
	var zoom = <?php echo $zoom; ?>;
	var opacity = 0.3;

        if (args.l)	layer_name = args.l;
        if (args.lat)	lat = args.lat;
        if (args.lon)	lon = args.lon;
        if (args.zoom)	zoom = args.zoom;
        if (args.opacity)	opacity = args.opacity;

	var map = new OpenLayers.Map("map", 
	{
		units:'m',
		projection: "EPSG:900913",
		displayProjection: new OpenLayers.Projection("EPSG:4326")
	});

	var osm = new OpenLayers.Layer.XYZ(
		"osm",
		"http://${s}.tile.openweathermap.org/map/osm/${z}/${x}/${y}.png",
		{
			numZoomLevels: 18, 
			sphericalMercator: true
		}
	);


    var mapnik = new OpenLayers.Layer.OSM();

	var opencyclemap = new OpenLayers.Layer.XYZ(
		"opencyclemap",
		"http://a.tile3.opencyclemap.org/landscape/${z}/${x}/${y}.png",
		{
			numZoomLevels: 18, 
			sphericalMercator: true
		}
	);

	var layer = new OpenLayers.Layer.XYZ(
		"layer "+layer_name,
		"http://${s}.tile.openweathermap.org/map/"+layer_name+"/${z}/${x}/${y}.png",
        //"http://wind.openweathermap.org/map/"+layer_name+"/${z}/${x}/${y}.png",
		{
//			numZoomLevels: 19, 
			isBaseLayer: false,
			opacity: opacity,
			sphericalMercator: true

		}
	);

	var centre = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), 
								new OpenLayers.Projection("EPSG:900913"));
	map.addLayers([mapnik, osm, opencyclemap, layer]);
        map.setCenter( centre, zoom);
	var ls = new OpenLayers.Control.LayerSwitcher({'ascending':false});
	map.addControl(ls);

	map.events.register("mousemove", map, function (e) {
		var position = map.getLonLatFromViewPortPx(e.xy).transform(new OpenLayers.Projection("EPSG:900913"), 
								new OpenLayers.Projection("EPSG:4326"));

		$("#mouse-<?php echo $rndn; ?>").html("Lat: " + Math.round(position.lat*100)/100 + " Lon: " + Math.round(position.lon*100)/100 + ' zoom: '+ map.getZoom());
	});
}
    init();
});
</script>
        <div class="mom-map-wrap" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;">
        <div id="map" class="weather-maps"></div>
        </div>
<?php             
	$content = ob_get_contents();
	ob_end_clean();
        return $content;
}
add_shortcode("weather_map", "mom_weather_map");


//Weather charts 
function mom_weather_chart ($atts, $content = null) {
   extract(shortcode_atts(array(
      "width" => '536',
      "height" => '370',
      "city" => 'Cairo',
      "units" => 'metric',
      "type" => 'dialy' /* daily, hourly*/
   ), $atts));
    $api_key = mom_option('weather_api_key');
if ($api_key == '') {
    //$api_key = '8cf2ffe6901005e706ec4e9c593588e2';
    echo __('Please Go to Theme options -> API\'s Authentication and add the weather API key');
    return;
}

if (isset($_POST['location']) && $_POST['location'] != '') {
    $city = $_POST['location'];
}

if (isset($_POST['units']) && $_POST['units'] != 'on') {
    $units = $_POST['units'];
} 
	ob_start();
        $rndn = rand(1,100);
            wp_enqueue_script('high_chart', get_template_directory_uri().'/js/highcharts.js', '', '1.0', false);
            wp_enqueue_script('high_chart_more', get_template_directory_uri() . '/js/highcharts-more.js', '', '1.0', false);
            //wp_enqueue_script('open_weather_chart', get_template_directory_uri().'/js/charts.js', '', '1.0', false);
$x = '';
if ($units == 'metric') {
    $x = '\u2103';
} elseif ($units == 'imperial') {
    $x = '\u2109';
}	    
    ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
var time_zone = 1000 * (new Date().getTimezoneOffset())*(-60);
	
var dailyurl = "http://api.openweathermap.org/data/2.5/forecast/daily?q=<?php echo $city; ?>&cnt=8&mode=json&units=<?php echo $units; ?>&appid=<?php echo $api_key; ?>";

var daily = [];
$.ajax({
  url: dailyurl,
  async: false,
  dataType: 'json',
  success: function (data) {
    daily = data.list;
  }
});

	var hourlyurl = "http://api.openweathermap.org/data/2.5/forecast?q=<?php echo $city; ?>&units=<?php echo $units; ?>&appid=<?php echo $api_key; ?>";

var forecast = [];
$.ajax({
  url: hourlyurl,
  async: false,
  dataType: 'json',
  success: function (data) {
    forecast = data.list;
  }
});


function showDailyChart()
{

	var time = new Array();
	var tmp = new Array();
	var tmpr = new Array();
	var rain = new Array();
	var snow = new Array();
	//var prcp = new Array();
	//var wind = new Array();


	for(var i = 1; i <  daily.length; i++){

		tmp.push( Math.round(10*(daily[i].temp.day))/10  );
		var dt = new Date( daily[i].dt * 1000 + time_zone);
		time.push( dt );

		var tmpi =  Math.round(10*(daily[i].temp.min))/10 ;
		var tmpa =  Math.round(10*(daily[i].temp.max))/10 ;
		tmpr.push( [tmpi, tmpa ]  );


		if(daily[i]['rain'])	{
			rain.push( Math.round(daily[i]['rain']*100) / 100 );
		}else{
			rain.push( 0 );			
		}
		if(daily[i]['snow'])	{
			snow.push( Math.round(daily[i]['snow']*100) / 100 );
		}else{
			snow.push( 0 );
		}
	}


	$('.chart-<?php echo $rndn; ?>').highcharts({
            chart: {
            //    zoomType: 'xy',
           		type: 'column'
            },
            title: NaN,
            xAxis: {
                categories: time,
				labels: {
				    formatter: function() {
						return Highcharts.dateFormat('%d %b', this.value);
				    }				    
            	}
            },

            yAxis: [
            {
                labels: {
                    format: '{value}<?php echo $x; ?>',
                    style: {
                        color: '#0083B9'
                    }
                },            	
                title: {
                    text: 'Temperature',
					style: {
                        color: '#0083B9'
                    }
                }
            },{
                labels: {
                    format: '{value} mm',
                    style: {
                        color: '#909090'
                    }
                },
                opposite: true,            	
                title: {
                    text: 'Precipitation',
                    style: {
                        color: '#8B8B8B'
                    }                    
                }
            }],
            tooltip: {
            	useHTML: true,
                shared: true,                
                formatter: function() {
 					var s = '<small>'+ Highcharts.dateFormat('%d %b', this.x) +'</small><table>';
                	$.each(this.points, function(i, point) {
                		//console.log(point);
                			if(point.y != 0)
                    			s += '<tr><td style="color:'+point.series.color+'">'+ point.series.name +': </td>'+
                        		'<td style="text-align: right"><b>'+point.y +'</b></td></tr>';
                	}
                	);
                	return s+'</table>';
				}
            },
			plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
			legend: NaN,
            series: [
            {
                name: 'Snow',
				type: 'column', 
				color: '#5B5B5B',      
				yAxis: 1,         
                data: snow,
                stack: 'precipitation'
            },
            {
                name: 'Rain',
				type: 'column', 
				color: '#8B8B8B',      
				yAxis: 1,         
                data: rain,
                stack: 'precipitation'
            },
			{
                name: 'Temperature',
				type: 'spline',
				color: '#0083B9',
                data: tmp
            },
            {
		        name: 'Temperature min',
		        data: tmpr,
		        type: 'arearange',
		        lineWidth: 0,
		    	linkedTo: ':previous',
		    	color: '#0083B9',
		    	fillOpacity: 0.3,
		    	zIndex: 0
		    } 
            ]
        });
}

function showHourlyForecastChart()
{

 	var curdate = new Date( (new Date()).getTime()- 180 * 60 * 1000 );

	var cnt=0;

	var time = new Array();
	var tmp = new Array();
 	var wind = new Array();
	var prcp = new Array();

	for(var i = 0; i <  forecast.length; i ++){

		var dt = new Date(forecast[i].dt * 1000);
	
		if( curdate  > dt )	continue;
		if(cnt > 10)		break;
		cnt++;

		tmp.push( Math.round(10*(forecast[i].main.temp))/10  );
		time.push( new Date( forecast[i].dt * 1000 + time_zone) );
		wind.push(forecast[i].speed);

		var p=0;
		if(forecast[i]['rain'] && forecast[i]['rain']['3h'])	p += forecast[i]['rain']['3h'];
		if(forecast[i]['snow'] && forecast[i]['snow']['3h'])	p += forecast[i]['snow']['3h'];
		prcp.push( Math.round( p * 10 ) / 10 );
	}

	$('.chart-<?php echo $rndn; ?>').highcharts({
            chart: {
                zoomType: 'xy',
		type: 'column'
            },
            title: NaN,

            xAxis: {
                categories: time,
                type: 'datetime',
				labels: {
				    formatter: function() {
						return Highcharts.dateFormat('%H:%M', this.value);
				    }				    
            	}
            },
            yAxis: [
            {
                labels: {
                    format: '{value}<?php echo $x; ?>',
                    style: {
                        color: '#0083B9'
                    }
                },
                opposite: true, 
                title:NaN
            },{
                labels: {
                    format: '{value}mm',
                    style: {
                        color: '#4572A7'
                    }
                },
                opposite: true,            	
                title: NaN
            }],
            tooltip: {
            	useHTML: true,
                shared: true,                
                formatter: function() {
 					var s = '<small>'+ Highcharts.dateFormat('%d %b. %H:%M', this.x) +'</small><table>';
                	$.each(this.points, function(i, point) {
                    		s += '<tr><td style="color:'+point.series.color+'">'+ point.series.name +': </td>'+
                        	'<td style="text-align: right"><b>'+point.y +'</b></td></tr>';
                	});
                	return s+'</table>';
				}
            },
			legend: {
                layout: 'vertical',
                align: 'left',
                x: -2,
                verticalAlign: 'top',
                y: -2,
                floating: true,
                backgroundColor: '#FFFFFF'
            }, 
            series: [
            {
                name: 'Precipitation',
				type: 'column',   
				color: '#8b8b8b',      
				yAxis: 1,
                data: prcp
            },{
                name: 'Temperature',
				type: 'spline',
				color: '#0083B9',
                data: tmp
            }]
        });
};

<?php if ($type == 'hourly') { ?>
showHourlyForecastChart();
<?php } else { ?>
showDailyChart();
<?php } ?>
});
</script>
    <div class="mom-chart chart-<?php echo $rndn; ?>" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px; margin-bottom: 25px;"></div>
<?php             
	$content = ob_get_contents();
	ob_end_clean();
        return $content;
}
add_shortcode("weather_chart", "mom_weather_chart");