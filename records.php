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

    <h1 class="well"><span class="glyphicon glyphicon-time"></span> Records </h1>
    <div class='col-md-12'>
      <div class='col-xs-4 col-md-4'>
        <h2>Generator running hours</h2>
      </div>
      <div class='col-xs-4 col-md-4'>
        <div class="panel panel-info">
          <div class="panel-heading"><h3>Today</h3></div>
          <h3><div class="panel-body" id = "d"></div></h3>
        </div>
      </div>
      <div class='col-xs-4 col-md-4'>
        <div class="panel panel-success">
          <div class="panel-heading"><h3>This Month</h3></div>
          <h3><div class="panel-body" id = "e"></div></h3>
        </div>
      </div>
    </div>
    <div class="col-md-12">
        <div class='col-xs-4 col-md-4'>
        <h2>Average fuel consumption</h2>
      </div>
      <div class='col-xs-4 col-md-4'>
        <div class="panel panel-info">
          <div class="panel-heading"><h3>Today</h3></div>
          <h3><div class="panel-body" id = "f"> Liters</div></h3>
        </div>
      </div>
      <div class='col-xs-4 col-md-4'>
        <div class="panel panel-success">
          <div class="panel-heading"><h3>This Month</h3></div>
          <h3><div class="panel-body" id = "g"></div></h3>
        </div>
      </div>
    </div>
    <p id = "d"></p>

    
    
    <!-- Put Anything-->
    </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  
  function fromFuncD(){
    var today = new Date();
    var year = 0;
    var month = 0;
    var date = 0;
    date =  today.getDate();
    year =  today.getFullYear();
    month = today.getMonth();
    day = new Date();
    day.setFullYear(year, month, date);
    day.setHours(0);
    day.setMinutes(0);
    day.setSeconds(0);
    day.setMilliseconds(0);

    
    var fromDTime = day.getTime();
    var untilTime = untilFunc();
    $.ajax({
      type: "POST",
      url: "ajax.php",
      data:{
         "fromDTime" : fromDTime,
         "untilTime": untilTime
      },
      async: false,
      success: function(msg){
        document.getElementById("d").innerHTML = msg + " minutes"; 
        document.getElementById("f").innerHTML = msg * 10 + " Liters";
      }
    });
  }

  function fromFuncM(){
    var today = new Date();
    var year = 0;
    var month = 0;
    //var date = 0;
    //date =  today.getDate();
    year =  today.getFullYear();
    month = today.getMonth();
    day = new Date();
    day.setFullYear(year, month, 1);
    day.setHours(0);
    day.setMinutes(0);
    day.setSeconds(0);
    day.setMilliseconds(0);

    var fromMTime = day.getTime();
    var untilTime = untilFunc();
    $.ajax({
      type: "POST",
      url: "ajax.php",
      data:{
         "fromMTime" : fromMTime,
         "untilTime": untilTime
      },
      async: false,
      success: function(msg){
        document.getElementById("e").innerHTML = msg + " minutes"; 
        document.getElementById("g").innerHTML = msg * 10 + " Liters";
        
      }
    });
  }

function untilFunc(){
  day = new Date();
  return day.getTime();
}

fromFuncD();
fromFuncM(); 
</script>
</body>


</html>


