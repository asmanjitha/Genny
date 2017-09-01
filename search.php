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


?>

<html>
<head>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

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

    <h1 class="well"><span class="glyphicon glyphicon-search"></span> Search</h1>
    <div class='col-xs-4 col-md-4'>
    <h3 class="well">From</h3>
         <div class="container">
          <div class="row">
              <div class='col-md-4'>
                  <div class="form-group">
                      <div class='input-group date' id='datetimepicker1'>
                          <input id='fromD' type='text' class="form-control" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                  </div>
              </div>
              <script type="text/javascript">
                  $(function () {
                      $('#datetimepicker1').datetimepicker();
                  });
              </script>
          </div>
      </div>
      </div>
  <div class='col-xs-4 col-md-4'>
    <h3 class="well">Until</h3>
         <div class="container">
          <div class="row">
              <div class='col-md-4'>
                  <div class="form-group">
                      <div class='input-group date' id='datetimepicker2'>
                          <input id='untilD' type='text' class="form-control" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                  </div>
              </div>
              <script type="text/javascript">
                  $(function () {
                      $('#datetimepicker2').datetimepicker();
                  });
              </script>
          </div>
      </div>
      </div>
    <div class='col-xs-12 col-md-12'>
    <div class='col-md-3'></div>
    <div class='col-md-4'>
      <button id="searchb"  type="button" class="btn btn-lg btn-info" name="searchb" onclick="addThisDrug();" >Search Statics</button>
    </div>
    </div>
    
    
    <!-- Put Anything-->
    </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function addThisDrug(){
  
  var from = $("#fromD").val();
  var until = $("#untilD").val();
  if(from==""){
    swal("Enter start time!","Start time can't be empty","error");
  }else if(until==""){
    swal("Enter end time!","Until time can't be empty","error");
  }else if (!dateValid(from)){
    swal("Start time error!","Start time can't be in future","error" );
  }else if(!dateValid1(until)){
    swal("Until time error", "Start time and Until time can't be same or past", "error");
  }else{
    //alert("validation successful");
    var fromT = setDate(from);
    var untilT = setDate(until);
    $.ajax({
      type: "POST",
      url: "ajax.php",
      data:{
         "fromT" : fromT,
         "untilT": untilT
      },
      async: false,
      success: function(msg){
        swal("Total running time: "+ msg+" mins\nTotal fuel consumption: "+msg*10 + " ltrs");
        
      }
    });
    
  }
  
}
function dateValid(arrival){
  //var d = new Date("2015-03-25T12:00:00Z");
  //alert(d);
  var datetime = arrival.split(" ");
  var arra = datetime[0].split("/");
  var time = datetime[1].split(":");

  if(time[0] == String("12") && datetime[2] == String("AM")){
    time[0] = "00";
  }
  else if(datetime[2] == String("PM")  && time[0] != String("12")){
    time[0] = String(Number(time[0]) + 12);
  }

  var date = new Date(arra[0]+" "+arra[1]+", "+arra[2]+" "+time[0]+":"+time[1]);

  //alert(date);
  var today= new Date();

  if(date.getTime() <=today.getTime()){
    return true;
  }else{
    return false;
  }
}

function dateValid1(arrival){
  var datetime = arrival.split(" ");

  var arra = datetime[0].split("/");
  var time = datetime[1].split(":");
  if(time[0] == String("12") && datetime[2] == String("AM")){
    time[0] = "00";
  }
  else if(datetime[2] == String("PM")  && time[0] != String("12")){
    time[0] = String(Number(time[0]) + 12);
  }
  var date = new Date(arra[0]+" "+arra[1]+", "+arra[2]+" "+time[0]+":"+time[1]);
  //alert(date);
  var today= new Date();
  if(date.getTime() <today.getTime()){
    return true;
  }else{
    return false;
  }
}

function setDate(arrival){
  //alert("setting date");
  var datetime = arrival.split(" ");

  var arra = datetime[0].split("/");
  var time = datetime[1].split(":");
  if(time[0] == String("12") && datetime[2] == String("AM")){
    time[0] = "00";
  }
  else if(datetime[2] == String("PM")){
    time[0] = String(Number(time[0]) + 12);
  }
  var date = new Date(arra[0]+" "+arra[1]+", "+arra[2]+" "+time[0]+":"+time[1]);
  //alert(date);
  return date.getTime();
}
</script> 
</body>


</html>