<?php
    include_once('esp-database.php');

    $result = getAllOutputs();
    $html_buttons = null;
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            if ($row["state"] == "0"){
                $button_checked = "checked";
            }
            else {
                $button_checked = "";
            }
            $html_buttons .= '<h3>' . $row["name"] . ' - Board '. $row["board"] . ' - GPIO ' . $row["gpio"] . '</h3><label class="switch"><input type="checkbox" onchange="updateOutput(this)" id="' . $row["id"] . '" ' . $button_checked . '><span class="slider"></span></label>';
        }
    }

    $result2 = getAllBoards();
    $html_boards = null;
    if ($result2) {
        $html_boards .= '<h3>Boards</h3>';
        while ($row = $result2->fetch_assoc()) {
            $row_reading_time = $row["last_request"];
            // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
            //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time"));

            // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
          $row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 2 hours"));
            $html_boards .= '<p><strong>Board ' . $row["board"] . '</strong> - Last Request Time: '. $row_reading_time . '</p>';
        }
    }
?>

<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Smart Pump</title>
  <!-- Font Awesome -->
  <!-- Bootstrap core CSS -->
     <!-- CSS only -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous"> <!-- JavaScript Bundle with Popper --> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script> 
   
  <!-- Material Design Bootstrap -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/css/mdb.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!--<link rel="shortcut icon" href="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/favicon.ico">-->
  <!-- Your custom styles (optional) -->
  <!-- this had NOTHING in it ???  -->
  <!-- link href="css/style.css" rel="stylesheet" -->
  
  
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
  
 <!-- MDB -->
   <!-- MDB -->
 <script
   type="text/javascript"
   src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js"
 ></script>
  
  
  <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <script src="https://kit.fontawesome.com/e503e95a46.js" crossorigin="anonymous"></script>
  
  
 
  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



   <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

   <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
   <!-- Graphs Stuff -->

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <link rel="stylesheet" type="text/css" href="esp-style.css">


     
<!-- Graphs Stuff End -->
	



</head>



  <!--Main Navigation-->
  <header>


    <nav class="navbar navbar-expand-lg navbar-dark primary-color-dark bg-info">
      <a class="navbar-brand ml-4" href="home.html"><strong>Smart Pump</strong></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="home.html">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item  active"> 
             <a class="nav-link" href="control.php">Control</a> 
          </li> 
          <!-- <li class="nav-item"> -->
            <!-- <a class="nav-link" href="#">Settings</a> -->
          <!-- </li> -->
		  
          
        </ul>
				  <ul class="navbar-nav "> 
				  <li class="nav-item active">
            <a class="nav-link d-flex justify-content-end" href="index.html">Logout</a>
          </li>
          
        </ul>
  
      </div>
    </nav>

  </header>
  
      <!-- header end -->


         <style>
        /* img[alt="www.000webhost.com"] 
         {opacity:0;} */ 
         img[src="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]
         {
display:none!important;
}
</style> 
<body>
    <h2>Things Control</h2>
    <div class="slider-container">
   <label for="slider">Manual</label>
   <input type="range" id="slider" name="mode" min="0" max="1" value="0" onchange="handleModeChange()">
      <label for="slider">Auto</label>
</div>
    <?php echo $html_buttons; ?>
    <br><br>
    <?php echo $html_boards; ?>
    <br><br>
   
    <script>
    
    document.addEventListener('DOMContentLoaded', function() {
  // make an AJAX request to get the current autonomy value from the database
  fetch('get_auto.php')
    .then(response => response.json())
    .then(data => {
      // set the current autonomy value as the slider value
      const slider = document.getElementById('slider');
      slider.value = data.autonomy;
    })
    .catch(error => {
      console.error('Failed to load autonomy:', error);
    });
});

        function updateOutput(element) {
            var xhr = new XMLHttpRequest();
            if(element.checked){
                xhr.open("GET", "esp-outputs-action.php?action=output_update&id="+element.id+"&state=0", true);
            }
            else {
                xhr.open("GET", "esp-outputs-action.php?action=output_update&id="+element.id+"&state=1", true);
            }
            xhr.send();
        }

        function deleteOutput(element) {
            var result = confirm("Want to delete this output?");
            if (result) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "esp-outputs-action.php?action=output_delete&id="+element.id, true);
                xhr.send();
                alert("Output deleted");
                setTimeout(function(){ window.location.reload(); });
            }
        }

        function createOutput(element) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "esp-outputs-action.php", true);

            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    alert("Output created");
                    setTimeout(function(){ window.location.reload(); });
                }
            }
            var outputName = document.getElementById("outputName").value;
            var outputBoard = document.getElementById("outputBoard").value;
            var outputGpio = document.getElementById("outputGpio").value;
            var outputState = document.getElementById("outputState").value;
            var httpRequestData = "action=output_create&name="+outputName+"&board="+outputBoard+"&gpio="+outputGpio+"&state="+outputState;
            xhr.send(httpRequestData);
        }
        
        
        function handleModeChange() {
  const slider = document.getElementById('slider');
  const autonomy = slider.value; // get the current value of the slider
  const data = { autonomy }; // create an object with the autonomy value
  
  // make an AJAX request to send the data to the server
  fetch('auto.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
  })
  .then(response => {
    if (response.ok) {
      console.log('Autonomy updated successfully!');
    } else {
      console.error('Failed to update autonomy:', response.status);
    }
  })
  .catch(error => {
    console.error('Failed to update autonomy:', error);
  });
}
    </script>
</body>
</html>
