<?php
session_start();
include('dbconnection.php'); //$conn
include('User.php');
include('basicTemp.php');

if(!isset($_SESSION['logged']) || !isset($_SESSION['user'])){
  header('location:login.php');
}
$pages = $_SESSION['pages'];
$user = unserialize($_SESSION['user']);
$selected_database = mysqli_select_db($conn, "genny");
//$todaytime = 1502631000000;
$query = "select * from day_currnet limit 144";
$query2 = "select * from datapoints limit 144";
$data = mysqli_query($conn, $query);
$data2 = mysqli_query($conn, $query2);
$dataPoints_current = array();
$dataPoints_voltage = array();
while ($row = mysqli_fetch_array($data, MYSQLI_ASSOC)) {
 /* $xd = $row["x"];
echo "<script type='text/javascript'>alert('$xd');</script>";*/
    array_push($dataPoints_current, $row);
}
while ($row = mysqli_fetch_array($data2, MYSQLI_ASSOC)) {
    array_push($dataPoints_voltage, $row);
}
?>
 
<html>
<head>  
  

<script type="text/javascript" src="assests\script\canvasjs.min.js"></script>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1">



<!--<link rel="stylesheet" href="../design.css">-->
<style>
.mySlides {display:none;}
</style>
<body>
<div class='container-fluid'>
  <div class='row'>
    <div class='col-xs-12 col-xs-12-height1 col-md-2 col-md-2-height1' id="sideB">
    <div class = "row">
    <ul class="nav nav-pills nav-stacked">
    <input type="hidden" value="<?php echo sizeof($pages);?>" id="nop">
      <?php
      foreach( $pages as $tempPag ) {?>
        <li><a style="color : black; font-family:Verdana,sans-serif;font-size:15px;line-height:1.5" href="<?php echo $tempPag[1]; ?>"><?php echo $tempPag[0]; ?></a></li>
      <?php      
      }; 

?>
    </ul>
    </div>
    </div>
    <div class='col-xs-12 col-md-10'  id="mb">
    <div class="row">
    <!-- Put Anything-->

    <h1 class="well"><span class="glyphicon glyphicon-stats"></span> Graphs</h1>
  <div id="chartContainer" style="height: 450px; width: 80%;"></div>
  <div id="chartContaine" style="height: 450px; width: 80%;"></div>



    
    <!-- Put Anything-->
    </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function () {
    var chart = new CanvasJS.Chart("chartContainer", {
        theme: "theme3",
        zoomEnabled: true,
        animationEnabled: true,
        title: {
            text: "Charging current variation (Today)"
        },
        data: [
        {
            type: "line",
            xValueType: "dateTime",
            dataPoints: <?php echo json_encode($dataPoints_current, JSON_NUMERIC_CHECK); ?>
        }
        ]
    });
    chart.render();
});
</script>

<script type="text/javascript">
  $(function () {
    var chart = new CanvasJS.Chart("chartContaine", {
        theme: "theme3",
        zoomEnabled: true,
        animationEnabled: true,

        title: {
            text: "Voltage variation (Today)"
        },
        data: [
        {
            type: "line",
            color: "#F07080",
            xValueType: "dateTime",
            dataPoints: <?php echo json_encode($dataPoints_voltage, JSON_NUMERIC_CHECK); ?>
        }
        ]
    });
    chart.render();
});
</script>
</body>


</html>