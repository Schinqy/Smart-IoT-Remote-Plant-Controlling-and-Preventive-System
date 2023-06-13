
   var dates = [];
   var humidity = [];
   var humidityNum = [];
   var temp =[];
   var tempNum =[];
   var vol = [];
   var volNum =[];
   var datas;
   var data2;
   
 
     
      function drawChart() {
        
// Set Data
var datas = new google.visualization.DataTable();
  datas.addColumn('string', 'dates');
  datas.addColumn('number', 'temp');
  for(i = 0;i<dates.length;i++)
  datas.addRow([dates.reverse()[i], tempNum.reverse()[i]]);
// Set Options
var options = {
  title: 'Temperature vs. Time',
  hAxis: {title: 'Time'},
  vAxis: {title: 'Temperature'},
  pointsVisible: 'true',
  colors: ['blue'],
  legend: 'none'
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('tempGraph'));
chart.draw(datas, options);
}

function drawChart2() {
// Set Data
var datas = new google.visualization.DataTable();
  datas.addColumn('string', 'dates');
  datas.addColumn('number', 'volume');
  for(i = 0;i<dates.length;i++)
  datas.addRow([dates.reverse()[i], volNum.reverse()[i]]);
// Set Options
var options = {
  title: 'Volume vs. Time',
  hAxis: {title: 'Time'},
  vAxis: {title: 'Volume'},
  pointsVisible: 'true',
  colors: ['blue'],
  legend: 'none'
  
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('volGraph'));
chart.draw(datas, options);
}


 function drawChart3() {

        

// Set Data
var datas = new google.visualization.DataTable();
  datas.addColumn('string', 'dates');
  datas.addColumn('number', 'humidity');
  for(i = 0;i<dates.length;i++)
  datas.addRow([dates.reverse()[i], humidityNum.reverse()[i]]);
// Set Options
var options = {
  title: 'Humidity vs. Time',
  hAxis: {title: 'Time'},
  vAxis: {title: 'Humidity'},
  pointsVisible: 'true',
  colors: ['blue'],
  legend: 'none'
  
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('humidityGraph'));
chart.draw(datas, options);
}


   var intervall;
   
   window.desktopcheck = function() {
  var check = false;
  if(window.innerWidth >768){
      check=true;
  }
  return check;
}


let firsttime = true;
let firstime = true;
let isIt = true;

function getDatah(){
 

    
      $.ajax({ 

        method: "GET", 
        
        url: "/api/mysql2json.php",

      }).done(function( data ) { 

        //var result= $.parseJSON(data); 
        var result = JSON.stringify(data);

        var resultt = JSON.parse(result);
       // alert(result);

console.log(JSON.parse(result));
    // var temps = Object.keys(result).map(([temp,date]) => ({temp,...date}));
     //console.log(temps);

     $.each( resultt, function( key, value ) { 
            
        vol.push((value['vol']));

			  for( var j=0; j <vol.length; j++ ){

            volNum.push(parseInt(vol[j]));
            }
			vol.length = 0;
			
        
            temp.push((value['temp']));
            for( var j=0; j <temp.length; j++ ){
            tempNum.push(parseInt(temp[j]));
            }
			  temp.length = 0;
			  humidity.push((value['humidity']));
			  for( var j=0; j <humidity.length; j++ ){
            humidityNum.push(parseInt(humidity[j]));
            }
			humidity.length = 0;
           dates.push((value['timestamp']));
           
           
     });
     //console.log(tempNum);
     
	 //console.log(humidityNum);
       //     console.log(dates);
 
 var volElement = document.getElementById('vol');
  if (volNum[0] < 20) {
    volElement.innerHTML = '<i class="vol fa-solid fa-bell fa-bounce fa-sm" style="color: red;"><label>Too Low - ' + volNum[0] + '% | Pump ON </label></i>';
  } else if (volNum[0] > 80) {
    volElement.innerHTML = '<i class="vol fa-solid fa-bell fa-bounce fa-sm" style="color: red;"><label>Almost Full - ' + volNum[0] + '% | Pump OFF </label></i>';
  } else {
    volElement.innerHTML = '<i class="fa-solid fa-thumbs-up fa-sm" style="color: #00ff00;"></i><label>Normal - ' + volNum[0] + '% </label></i>';
  }


 var tempElement = document.getElementById('temp');
  if (tempNum[0] < 15) {
    tempElement.innerHTML = '<i class="temp fa-solid fa-bell fa-bounce fa-sm" style="color: red;"><label>Too Low - ' + tempNum[0] + '% | Heater ON - Fan OFF </label></i>';
  } else if (tempNum[0] > 40) {
    tempElement.innerHTML = '<i class="temp fa-solid fa-bell fa-bounce fa-sm" style="color: red;"><label>Too High - ' + tempNum[0] + '% | Heater OFF - Fan ON </label></i>';
  } else {
    tempElement.innerHTML = '<i class="fa-solid fa-thumbs-up fa-sm" style="color: #00ff00;"></i><label>Normal - ' + tempNum[0] + '% </label></i>';
  }

  var humidElement = document.getElementById('humid');
  if (humidityNum[0] < 15) {
    humidElement.innerHTML = '<i class="humid fa-solid fa-bell fa-bounce fa-sm" style="color: red;"><label>Too Low - ' + humidityNum[0] + '% </label></i>';
  } else if (humidityNum[0] > 75) {
    humidElement.innerHTML = '<i class="humid fa-solid fa-bell fa-bounce fa-sm" style="color: red;"><label>Too High - ' + humidityNum[0] + '% </label></i>';
  } else {
    humidElement.innerHTML = '<i class="fa-solid fa-thumbs-up fa-sm" style="color: #00ff00;"></i><label>Normal - ' + humidityNum[0] + '% </label></i>';
  }
          
drawChart();
drawChart2();
drawChart3();

      tempNum.length = 0;
	  humidityNum.length = 0;
      dates.length = 0;


      
      });  
      
}


$(document).ready(function(){

setInterval(getDatah, 2000);
});


