/* taken from styles-with-shortcodes */

function rhc_gmap3_init(obj){
	jQuery(document).ready(function($){
		var address = obj.address;
		if(address!='' && obj.glat==0 && obj.glon==0 ){
		    var geocoder_map = new google.maps.Geocoder();
			geocoder_map.geocode( { 'address': address}, function(results, status) {
				obj.address='';
				if (status == google.maps.GeocoderStatus.OK) {
					latlng = results[0].geometry.location;
					obj.glat = latlng.lat();
					obj.glon = latlng.lng();
				}
				return rhc_gmap3_init(obj);
			});			
		}
		
	    var latlng = new google.maps.LatLng( obj.glat, obj.glon);
	    var myOptions = {
		  scrollwheel: (typeof obj.scrollwheel=='undefined' ? true :obj.scrollwheel),
	      zoom: obj.zoom,
	      center: latlng,
		  disableDefaultUI: obj.disableDefaultUI,
	      mapTypeId: obj.map_type
	    };

	    var map = new google.maps.Map(document.getElementById("map_canvas"+obj.uid), myOptions);
		var infowindow = new google.maps.InfoWindow({
		    content: document.getElementById(obj.info_windows)
		});

		if( 'object' == typeof obj.styles ){
			map.setOptions({styles: obj.styles});
		}
	
		if(obj.traffic){
			var trafficLayer = new google.maps.TrafficLayer();
			trafficLayer.setMap(map);
		}
	
		var marker = new google.maps.Marker({position: latlng,map: map,title:obj.name});
		google.maps.event.addListener(marker, 'click', function() {
		  infowindow.open(map,marker);
		});	
		
		var _markers_sel = obj.markers;
		var _markers = $(_markers_sel).html();

		var arr = _markers.split('::');
		var mmarker = [];
		var marker_content = [];
		if(arr.length>0){
			for(var a=0;a<arr.length;a++){
				var brr = arr[a].split('|');
				if(brr.length==4){
					if(brr[0].replace(' ','')==''){	continue;}
					var mlatlng = new google.maps.LatLng(brr[0], brr[1]);
					
					marker_content[a] = brr[3];	
					mmarker[a] = new google.maps.Marker({position: mlatlng,map: map,title:brr[2]});
					attachInfo(mmarker[a],a);
				}
			}
		}	
		
		function attachInfo(_marker, number) {
		    var infowindow = new google.maps.InfoWindow({ content: marker_content[number]});
		    google.maps.event.addListener(_marker, 'click', function() {
		        infowindow.open(map,_marker);
			});
		} 		
	});
}