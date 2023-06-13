<?php
 require('connection.php');
  $result=mysqli_query($conn, "SELECT id, humidity, vol, temp, CONVERT_TZ(timestamp, '+00:00', '+02:00') AS timestamp FROM PumpData ORDER BY id DESC LIMIT 40;");
  $result_array = array();
  // if (mysqli_num_rows($resultt)<1){
    // $result = null;
  // }
   // if ($result) {
                          
    // $roww=mysqli_fetch_array($resultt);
    // $longitude = $roww['longitude'];
      // $latitude =  $roww['latitude'];
      // $dist = $roww['dist2dest'];
 // $spd =  $roww['speed'];
 // $time = $dist / $spd ;
  
 // $timeinmin = $time * 60;
   // }
   
   // echo $timeinmin;
   
   if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($result_array, $row);
    }
}
/* send a JSON encded array to client */
header('Content-type: application/json');
echo json_encode($result_array);
$conn->close();
   
   // if(isset($_GET['userName'])) ? $_POST['userName'] : 'no name';
// $computedString = "Hi, " . $name . "!";
// $array = ['userName' => $name, 'computedString' => $computedString];
// echo json_encode($array);
?>