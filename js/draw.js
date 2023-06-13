			var height=0; 
      	var map;
      	var waypointx;
      	var vol;
		let myChart = null;
		var arrayTime2;
		var arrayVol = [];
		var latDS;
		var lngDS;
							var arrayTime = [];
var arrayLat = [];
var arrayLng = [];
	
		
//**************************DRAW MAP*************************************************************
      	function initMap() {
        	  
			 var myLatlng = new google.maps.LatLng(-19.5162395065, 29.8393305711);
        var mapOptions = {
          zoom: 13,
          center: myLatlng
        }
		
		var icon = {
    url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
    scaledSize: new google.maps.Size(50, 50)
};

         map = new google.maps.Map(document.getElementById("map"), mapOptions);
        var marker = new google.maps.Marker({
          position: myLatlng,
          title:"Reservoir Location" ,
		  icon: icon
        });
		marker.setMap(map);
		marker.setAnimation(google.maps.Animation.BOUNCE);
		
		 const contentString = "<a> Reservoir Location </a><a>" ;
  const infowindow = new google.maps.InfoWindow({
    content: contentString,
    ariaLabel: "Uluru",
  });


  marker.addListener("click", () => {
    infowindow.open({
      anchor: marker,
      map,
    });
  });
	    }
 

window.initMap = initMap;
//**************************DRAW MAP END*************************************************************

//**************************GET DATA*************************************************************




        






     
			




