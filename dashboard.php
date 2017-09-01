<?php
session_start();
include('dbconnection.php'); //$conn
include('User.php');
include('basictemp.php');

if(!isset($_SESSION['logged']) || !isset($_SESSION['user'])){
  header('location:login.php');
}
$pages = $_SESSION['pages'];
$user = unserialize($_SESSION['user']);

$query1 = "select * from details where msg_id = (select MAX(msg_id) from details)";
mysqli_select_db($conn,"genny");
$res = mysqli_query($conn,$query1);
if($res){   
  $row=mysqli_fetch_array($res,MYSQLI_ASSOC);
  $voltage = $row['voltage']; 
  $current = $row['current']; 
  $state = $row['state'];  
}else{
  echo "server error";
}
?>


<html>
<head>

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

    <h1 class="well"><span class="glyphicon glyphicon-th-list"></span> Dashboard</h1>
    <div class='col-xs-10 col-md-9'>
      <div class="panel panel-info">
        <div class="panel-heading"><h3>Batery Voltage</h3></div>
        <div class="panel-body"><h3><?php echo $voltage ?> Volts</h3></div>
      </div>
      <div class="panel panel-info">
        <div class="panel-heading"><h3>Charging Current</h3></div>
        <div class="panel-body"><h3><?php echo $current ?> Amperes</h3></div>
      </div>
      <div class="panel panel-danger">
        <div class="panel-heading"><h2>Generator Staus</h2></div>
        <div class="panel-body"><h2><?php echo $state ?></h2></div>
      </div>
    </div>
    
    
    
    
    <!-- Put Anything-->
    </div>
    </div>
  </div>
</div>
<script type="text/javascript">
</script>
</body>


</html>


