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

$password= "To be filled";

$applicationId = "APP_999999";

$serverurl= "To be filled";


 


try{
	/*************************************************************/
	$receiver = new SMSReceiver(file_get_contents('php://input'));
	$content =$receiver->getMessage();
	echo $content;
	$content=preg_replace('/\s{2,}/',' ', $content); 
	$address = $receiver->getAddress();
	$address = $receiver->getAddress();
	$requestId = $receiver->getRequestID();
	$applicationId = $receiver->getApplicationId();
	/*************************************************************/
	$gen_voltage;
	$gen_current;
	$state;

	//$sender = new SMSSender($serverurl, $applicationId, $password);
	//echo "***ASM****";
	
	list($key, $second) = explode(" ",$content);
	echo $second;
	

 

	
	 if ($second[2]=="v" && $second[5] == "a") {
       	
		//Broadcasting A Message
			$current_voltage = substr($second,0,3);
			$current_current = substr($second,4,-1);
			settype($current_voltage, "integer");
			settype($current_currnet, "integer");
	     	
	     	if ($current_voltage <= 48){
	     		//$sender->sendMessage("On",$address);
	     		$state = "On";
	     	}else if (($current_voltage > 48 && $current_voltage <= 53) && $current_current >= 10){
	     		//$sender->sendMessage("Off",$address);
	     		$state = "Off";
	     	}else if (($current_voltage > 48 && $current_voltage <= 53) && $current_current < 10){
	     		//$sender->sendMessage("Off",$address);
	     		$state = "On";
	     	}else{
	     		$state = "Off";
	     	}

	     	$milliseconds = round(microtime(true) * 1000);
	     	$selected_database = mysqli_select_db($conn, "genny");
       		$query1 = "insert into genny.details (mili_time,state,voltage,current) values ('$milliseconds','$state','$current_voltage','$current_current')";
       		$query2 = "insert into genny.current_data (x,y) values ('$mili_time','$current_current')";
       		$query3 = "insert into genny.voltage_data (x,y) values ('$mili_time','$current_voltge')";
       		$ins = mysqli_query($conn,$queryl);
       		$ins = mysqli_query($conn,$query2);
       		$ins = mysqli_query($conn,$query3);
	     	
	   }else{

		//Replying to an individual Message
		
	     	error_log("Message received ".$content);
	
	     	//$sender->sendMessage("Format error, check the sending msg".$second,$address);

	      
             }


						

	}catch(SMSServiceException $e){

	     	error_log("Passed Exception ".$e);

	
	}

?>
