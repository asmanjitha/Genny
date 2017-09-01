<?php
/*
Author : Shafraz Rahim
*/
ini_set('error_log', 'sms-app-error-jedi.log');
include 'lib/SMSSender.php';
include 'lib/SMSReceiver.php';
include('dbconnection.php');
date_default_timezone_set("Asia/Colombo");
/*** To be filled ****/
$password= "password";
$applicationId = "APP_000001";
$serverurl= "http://localhost:7000/sms/send";
 
try{
	/*************************************************************/
	$receiver = new SMSReceiver(file_get_contents('php://input'));
	$content =$receiver->getMessage();
	$content=preg_replace('/\s{2,}/',' ', $content); 
	$address = $receiver->getAddress();
	$address = $receiver->getAddress();
	$requestId = $receiver->getRequestID();
	$applicationId = $receiver->getApplicationId();
	/*************************************************************/
	
	$sender = new SMSSender($serverurl, $applicationId, $password);
	$state;
	
	list($key, $second) = explode(" ",$content);
	
	
 
	
	 if ($second=="go") {
       	
		//Broadcasting A Message
		
	     	//$boradmsg = substr($content,7);
       
	     	error_log("Broadcast Message ".$content);
		
	     	$response=$sender->sendMessage("Broadcasting ".$second,$address);
	   }else{
		//Replying to an individual Message
		
	     	error_log("Message received ".$content);

	     	$current_voltage = substr($second,0,5);
			$current_current = substr($second,6,-1);
			settype($current_voltage, "float");
			settype($current_currnet, "float");
	     	
	     	if ($current_voltage <= 48){
	     		//$sender->sendMessage("On",$address);
	     		$state = "on";
	     	}else if (($current_voltage > 48 && $current_voltage <= 53) && $current_current >= 10){
	     		//$sender->sendMessage("Off",$address);
	     		$state = "off";
	     	}else if (($current_voltage > 48 && $current_voltage <= 53) && $current_current < 10){
	     		//$sender->sendMessage("Off",$address);
	     		$state = "on";
	     	}else{
	     		$state = "off";
	     	}

	     	$milliseconds = round(microtime(true) * 1000);
	     	$selected_database = mysqli_select_db($conn, "genny");
       		$query = "insert into genny.details (voltage,current,state,mili_time) values ('$current_voltage','$current_current','$state','$milliseconds')";
       		$ins = mysqli_query($conn,$query);
       		$query = "insert into genny.day_currnet (x,y) values ('$milliseconds','$current_current')";
			$ins = mysqli_query($conn,$query);
       		$query = "insert into genny.datapoints (x,y) values ('$milliseconds','$current_voltage')";
			$ins = mysqli_query($conn,$query);
       		/*mysqli_query($conn,$query2);
       		mysqli_query($conn,$query3);*/
	
	     	//$sender->sendMessage("May the force be with you Jedi Master ".$second,$address);
	     	$query1 = "select * from details where msg_id = (select MAX(msg_id) from details)-1";
			mysqli_select_db($conn,"genny");
			$res = mysqli_query($conn,$query1);
			if($res){   
			  $row=mysqli_fetch_array($res,MYSQLI_ASSOC); 
			  $previous_state = $row['state'];  
			}else{
			  echo "server error";
			}
			if ($previous_state == $state){
	     		//$sender->sendMessage("previous_state",$address);
	      	}else{
	      		$sender->sendMessage($state,$address);
	      	}

	      	
             }
						
	}catch(SMSServiceException $e){
	     	error_log("Passed Exception ".$e);
	
	}
?>