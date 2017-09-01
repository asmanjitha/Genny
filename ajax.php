<?php
include("dbconnection.php");

if(isset($_REQUEST["fromT"]) && isset($_REQUEST["untilT"])){
	$from = $_REQUEST["fromT"];
	$until = $_REQUEST["untilT"];

	$query1 = "SELECT msg_id from messages where (mili_time>='$from' && mili_time<'$until')";
	mysqli_select_db($conn,"genny");
	$res = mysqli_query($conn,$query1);
	$ret = 0;
	$ids = array();
	if($res){
		
		while($row=mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$id = $row['msg_id'];
			array_push($ids,$id);
		}
		
	}
	foreach ($ids as $id) {
		mysqli_select_db($conn,"genny");
		$query2 = "select * from details where msg_id='$id'";
		$res = mysqli_query($conn,$query2);
		$row=mysqli_fetch_array($res,MYSQLI_ASSOC);
		if($row['state'] == 'on'){
			$ret++;
		}
	}
	echo $ret*10 ;
	exit();
}

if(isset($_REQUEST["fromDTime"]) && isset($_REQUEST["untilTime"])){//give two milisecond vlues to $from and $until
	$from = $_REQUEST["fromDTime"];
	$until = $_REQUEST["untilTime"];
  $query1 = "SELECT msg_id from messages where (mili_time>='$from' && mili_time<'$until')";
  mysqli_select_db($conn,"genny");
  $res = mysqli_query($conn,$query1);
  $ret = 0;
  $ids = array();
  if($res){
    
    while($row=mysqli_fetch_array($res,MYSQLI_ASSOC)){
      $id = $row['msg_id'];
      array_push($ids,$id);
    }
    
  }
  foreach ($ids as $id) {
    mysqli_select_db($conn,"genny");
    $query2 = "select * from details where msg_id='$id'";
    $res = mysqli_query($conn,$query2);
    $row=mysqli_fetch_array($res,MYSQLI_ASSOC);
    if($row['state'] == 'on'){
      $ret++;
    }
  }
  echo $ret*10;
  exit();
}

if(isset($_REQUEST["fromMTime"]) && isset($_REQUEST["untilTime"])){//give two milisecond vlues to $from and $until
	$from = $_REQUEST["fromMTime"];
	$until = $_REQUEST["untilTime"];
  $query1 = "SELECT msg_id from messages where (mili_time>='$from' && mili_time<'$until')";
  mysqli_select_db($conn,"genny");
  $res = mysqli_query($conn,$query1);
  $ret = 0;
  $ids = array();
  if($res){
    
    while($row=mysqli_fetch_array($res,MYSQLI_ASSOC)){
      $id = $row['msg_id'];
      array_push($ids,$id);
    }
    
  }
  foreach ($ids as $id) {
    mysqli_select_db($conn,"genny");
    $query2 = "select * from details where msg_id='$id'";
    $res = mysqli_query($conn,$query2);
    $row=mysqli_fetch_array($res,MYSQLI_ASSOC);
    if($row['state'] == 'on'){
      $ret++;
    }
  }
  echo $ret*10;
  exit();
}


?>